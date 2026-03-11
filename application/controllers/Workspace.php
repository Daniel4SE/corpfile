<?php
/**
 * Lightweight workspace pages aligned to the new reference layout.
 * Handles: /registration, /events_alerts, /workflow, /agents
 */

class Workspace_section extends BaseController {
    protected function getClient() {
        if (!$this->db) {
            return null;
        }

        $clientCode = $_SESSION['client_id'] ?? '';
        if (!$clientCode) {
            return null;
        }

        return $this->db->fetchOne("SELECT * FROM clients WHERE client_id = ?", [$clientCode]);
    }

    protected function getUserId() {
        return (int) ($_SESSION['user_id'] ?? 0);
    }

    protected function daysUntil($dateValue) {
        if (empty($dateValue)) {
            return null;
        }

        try {
            $today = new DateTimeImmutable('today');
            $target = new DateTimeImmutable($dateValue);
            return (int) $today->diff($target)->format('%r%a');
        } catch (Exception $e) {
            return null;
        }
    }

    protected function urgencyTone($dateValue) {
        $days = $this->daysUntil($dateValue);
        if ($days === null) {
            return 'neutral';
        }
        if ($days < 0 || $days <= 7) {
            return 'danger';
        }
        if ($days <= 30) {
            return 'warning';
        }
        return 'success';
    }
}

class Registration extends Workspace_section {
    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'Registration',
            'cases' => [],
            'recent_templates' => [],
            'metrics' => [
                'pending' => 0,
                'with_docs' => 0,
                'unassigned' => 0,
                'templates' => 0,
            ],
        ];

        $client = $this->getClient();
        if ($client) {
            $data['cases'] = $this->db->fetchAll(
                "SELECT c.id, c.company_name, c.registration_number, c.acra_registration_number, c.country,
                        c.created_at, c.updated_at, c.internal_css_status, c.incorporation_date,
                        COALESCE(
                            (SELECT GROUP_CONCAT(u.name SEPARATOR ', ')
                             FROM company_pic cp
                             JOIN users u ON u.id = cp.user_id
                             WHERE cp.company_id = c.id),
                            NULLIF(c.contact_person, ''),
                            'Unassigned'
                        ) AS pic_name,
                        (SELECT COUNT(*) FROM documents d WHERE d.entity_type = 'company' AND d.entity_id = c.id) AS documents_count
                 FROM companies c
                 WHERE c.client_id = ?
                   AND (c.internal_css_status = 'Pre-Incorporation' OR c.incorporation_date IS NULL)
                 ORDER BY COALESCE(c.updated_at, c.created_at) DESC
                 LIMIT 40",
                [$client->id]
            );

            $data['recent_templates'] = $this->db->fetchAll(
                "SELECT id, template_name, created_at
                 FROM form_templates
                 WHERE client_id = ?
                 ORDER BY created_at DESC, template_name ASC
                 LIMIT 8",
                [$client->id]
            );

            $data['metrics']['pending'] = count($data['cases']);
            $data['metrics']['templates'] = (int) $this->db->count('form_templates', 'client_id = ?', [$client->id]);

            foreach ($data['cases'] as $case) {
                if ((int) ($case->documents_count ?? 0) > 0) {
                    $data['metrics']['with_docs']++;
                }
                if (($case->pic_name ?? '') === 'Unassigned') {
                    $data['metrics']['unassigned']++;
                }
            }
        }

        $this->loadLayout('workspace/registration', $data);
    }
}

class Events_alerts extends Workspace_section {
    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'Events & Alerts',
            'notifications' => [],
            'alerts' => [],
            'activity_logs' => [],
            'metrics' => [
                'unread' => 0,
                'overdue' => 0,
                'next_30_days' => 0,
                'notifications' => 0,
            ],
        ];

        $client = $this->getClient();
        $userId = $this->getUserId();

        if ($userId) {
            $data['notifications'] = $this->db->fetchAll(
                "SELECT id, title, message, link, is_read, created_at
                 FROM notifications
                 WHERE user_id = ?
                 ORDER BY created_at DESC
                 LIMIT 20",
                [$userId]
            );

            foreach ($data['notifications'] as $notification) {
                if (empty($notification->is_read)) {
                    $data['metrics']['unread']++;
                }
            }
            $data['metrics']['notifications'] = count($data['notifications']);
        }

        if ($client) {
            $data['alerts'] = $this->db->fetchAll(
                "SELECT d.id, d.company_id, COALESCE(c.company_name, d.company_name, 'Corporate record') AS company_name,
                        d.event_name, d.due_date, d.pic, d.status
                 FROM due_dates d
                 LEFT JOIN companies c ON c.id = d.company_id
                 WHERE d.client_id = ?
                   AND d.due_date IS NOT NULL
                 ORDER BY d.due_date ASC
                 LIMIT 30",
                [$client->id]
            );

            foreach ($data['alerts'] as $alert) {
                $days = $this->daysUntil($alert->due_date);
                $alert->days_remaining = $days;
                $alert->tone = $this->urgencyTone($alert->due_date);
                $alert->href = !empty($alert->company_id) ? base_url('view_company/' . $alert->company_id) : base_url('event_tracker');

                if ($days !== null && $days < 0) {
                    $data['metrics']['overdue']++;
                }
                if ($days !== null && $days >= 0 && $days <= 30) {
                    $data['metrics']['next_30_days']++;
                }
            }

            $data['activity_logs'] = $this->db->fetchAll(
                "SELECT ul.action, ul.module, ul.created_at, COALESCE(u.name, 'System') AS user_name
                 FROM user_logs ul
                 LEFT JOIN users u ON u.id = ul.user_id
                 WHERE ul.client_id = ?
                 ORDER BY ul.created_at DESC
                 LIMIT 12",
                [$client->id]
            );
        }

        $this->loadLayout('workspace/events_alerts', $data);
    }
}

class Workflow extends Workspace_section {
    private function resolveStage($item) {
        if (!empty($item['completed_date'])) {
            return 'done';
        }
        if (!empty($item['approval_flag'])) {
            return 'pending_review';
        }
        if (!empty($item['start_date'])) {
            return 'in_progress';
        }
        return 'intake';
    }

    public function index() {
        $this->requireAuth();

        $data = [
            'page_title' => 'Workflow (SOP)',
            'lanes' => [
                'intake' => ['label' => 'Intake', 'items' => []],
                'in_progress' => ['label' => 'In Progress', 'items' => []],
                'pending_review' => ['label' => 'Pending Review', 'items' => []],
                'done' => ['label' => 'Done', 'items' => []],
            ],
            'metrics' => [
                'open' => 0,
                'due_this_week' => 0,
                'pending_review' => 0,
                'done' => 0,
            ],
        ];

        $client = $this->getClient();
        if ($client) {
            $taskRows = [];

            try {
                $taskRows = $this->db->fetchAll(
                    "SELECT t.id, t.task_name, t.description, t.start_date, t.due_date, t.completed_date, t.actual_hours, t.project_id,
                            COALESCE(c.company_name, p.project_name, 'Internal Workflow') AS subject_name,
                            COALESCE(u.name, 'Unassigned') AS assignee_name
                     FROM tasks t
                     LEFT JOIN companies c ON c.id = t.company_id
                     LEFT JOIN projects p ON p.id = t.project_id
                     LEFT JOIN users u ON u.id = t.assigned_to
                     WHERE t.client_id = ?
                     ORDER BY COALESCE(t.due_date, '9999-12-31') ASC, t.created_at DESC
                     LIMIT 40",
                    [$client->id]
                );
            } catch (Exception $e) {
                $taskRows = [];
            }

            foreach ($taskRows as $taskRow) {
                $item = [
                    'subject_name' => $taskRow->subject_name ?: 'Workflow item',
                    'task_name' => $taskRow->task_name ?: 'Untitled task',
                    'description' => $taskRow->description ?: 'SOP-driven work item.',
                    'start_date' => $taskRow->start_date,
                    'due_date' => $taskRow->due_date,
                    'completed_date' => $taskRow->completed_date,
                    'approval_flag' => !empty($taskRow->actual_hours) && empty($taskRow->completed_date),
                    'assignee_name' => $taskRow->assignee_name ?: 'Unassigned',
                    'tone' => $this->urgencyTone($taskRow->due_date),
                    'href' => !empty($taskRow->project_id) ? base_url('crm_project_view/' . $taskRow->project_id) : base_url('tasks'),
                ];

                $laneKey = $this->resolveStage($item);
                $data['lanes'][$laneKey]['items'][] = $item;
            }

            if (empty($taskRows)) {
                $alertRows = $this->db->fetchAll(
                    "SELECT d.company_id, COALESCE(c.company_name, d.company_name, 'Corporate record') AS company_name,
                            d.event_name, d.due_date, d.pic, d.status
                     FROM due_dates d
                     LEFT JOIN companies c ON c.id = d.company_id
                     WHERE d.client_id = ?
                       AND d.due_date IS NOT NULL
                     ORDER BY d.due_date ASC
                     LIMIT 16",
                    [$client->id]
                );

                foreach ($alertRows as $index => $alertRow) {
                    $item = [
                        'subject_name' => $alertRow->company_name ?: 'Corporate record',
                        'task_name' => ($alertRow->event_name ?: 'Compliance') . ' workflow',
                        'description' => 'Auto-routed from the current alert and due-date queue.',
                        'start_date' => null,
                        'due_date' => $alertRow->due_date,
                        'completed_date' => null,
                        'approval_flag' => ((int) $index % 3) === 0,
                        'assignee_name' => $alertRow->pic ?: 'PIC Auto-route',
                        'tone' => $this->urgencyTone($alertRow->due_date),
                        'href' => !empty($alertRow->company_id) ? base_url('view_company/' . $alertRow->company_id) : base_url('event_tracker'),
                    ];

                    $laneKey = $this->resolveStage($item);
                    $data['lanes'][$laneKey]['items'][] = $item;
                }
            }
        }

        foreach ($data['lanes'] as $laneKey => $lane) {
            foreach ($lane['items'] as $item) {
                if ($laneKey !== 'done') {
                    $data['metrics']['open']++;
                } else {
                    $data['metrics']['done']++;
                }
                if ($laneKey === 'pending_review') {
                    $data['metrics']['pending_review']++;
                }
                $days = $this->daysUntil($item['due_date'] ?? null);
                if ($days !== null && $days >= 0 && $days <= 7) {
                    $data['metrics']['due_this_week']++;
                }
            }
        }

        $this->loadLayout('workspace/workflow', $data);
    }
}

class Agents extends Workspace_section {
    public function index() {
        $this->requireAuth();

        $stateDir = getenv('AI_STATE_DIR') ?: ((getenv('HOME') ?: '') . '/.corpfile-ai');

        $data = [
            'page_title' => 'AI Agents',
            'ai_status_endpoint' => base_url('ai/status'),
            'ai_run_endpoint' => base_url('ai/run'),
            'starter_prompts' => [
                [
                    'task' => 'deadline_pressure',
                    'label' => 'Summarize filing pressure',
                    'prompt' => 'Summarize the current IR8A and tax filing pressure for the next 30 days.',
                ],
                [
                    'task' => 'missing_information',
                    'label' => 'Find missing records',
                    'prompt' => 'Review the current IR8A workflow and tell me which records are still missing before filing.',
                ],
                [
                    'task' => 'follow_up',
                    'label' => 'Draft follow-up notes',
                    'prompt' => 'Draft concise follow-up actions for the companies with the most urgent tax deadlines.',
                ],
                [
                    'task' => 'checklist',
                    'label' => 'Build an IR8A checklist',
                    'prompt' => 'Build an IR8A readiness checklist grounded in the visible CorpFile documents and deadlines.',
                ],
                [
                    'task' => 'payroll_compliance',
                    'label' => 'Check payroll compliance',
                    'prompt' => 'Check SDL, payslip timing, payroll completeness, and IR8A readiness risks using the current CorpFile records.',
                ],
            ],
            'tax_documents' => [],
            'tax_deadlines' => [],
            'metrics' => [
                'ir8a_files' => 0,
                'tax_deadlines' => 0,
                'payroll_clients' => 0,
                'templates' => 0,
            ],
        ];

        $client = $this->getClient();
        if ($client) {
            $data['tax_documents'] = $this->db->fetchAll(
                "SELECT id, document_name, file_path, created_at
                 FROM documents
                 WHERE client_id = ?
                   AND (
                        document_name LIKE '%IR8A%'
                        OR document_name LIKE '%Tax%'
                        OR document_name LIKE '%payroll%'
                   )
                 ORDER BY created_at DESC
                 LIMIT 16",
                [$client->id]
            );

            $data['tax_deadlines'] = $this->db->fetchAll(
                "SELECT d.company_id, COALESCE(c.company_name, d.company_name, 'Corporate record') AS company_name,
                        d.event_name, d.due_date, d.status
                 FROM due_dates d
                 LEFT JOIN companies c ON c.id = d.company_id
                 WHERE d.client_id = ?
                   AND d.event_name IN ('Tax Return', 'ECI', 'Annual Filing')
                 ORDER BY COALESCE(d.due_date, '9999-12-31') ASC
                 LIMIT 20",
                [$client->id]
            );

            foreach ($data['tax_deadlines'] as $deadline) {
                $deadline->tone = $this->urgencyTone($deadline->due_date);
                $deadline->href = !empty($deadline->company_id) ? base_url('view_company/' . $deadline->company_id) : base_url('documents');
            }

            $data['metrics']['ir8a_files'] = count($data['tax_documents']);
            $data['metrics']['tax_deadlines'] = count($data['tax_deadlines']);
            $data['metrics']['payroll_clients'] = (int) $this->db->count('companies', 'client_id = ? AND is_payroll_client = 1', [$client->id]);
            $data['metrics']['templates'] = (int) $this->db->count('form_templates', 'client_id = ?', [$client->id]);
        }

        $this->loadLayout('workspace/agents', $data);
    }
}
