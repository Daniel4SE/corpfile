<?php
/**
 * CRM Controller - CRM Module
 * Handles: /crm, /crm_dashboard, /crm_leads, /add_lead, /crm_quotations,
 *          /crm_sales_order, /crm_invoices, /crm_projects, /crm_tasks,
 *          /crm_activities, /crm_timesheets
 */
class Crm extends BaseController {
    
    public function index() {
        $this->requireAuth();
        $this->redirect('crm_dashboard');
    }
}

// CRM Dashboard controller (maps to /crm_dashboard)
class Crm_dashboard extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'CRM Dashboard'];
        $this->loadLayout('crm/dashboard', $data);
    }
}

// CRM Leads listing (maps to /crm_leads)
class Crm_leads extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Leads',
            'leads' => [],
        ];
        $this->loadLayout('crm/leads', $data);
    }
}

// Add Lead form (maps to /add_lead)
class Add_lead extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Add Lead',
            'users' => [],
        ];
        $this->loadLayout('crm/add_lead', $data);
    }
}

// CRM Quotations listing (maps to /crm_quotations)
class Crm_quotations extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Quotations',
            'quotations' => [],
        ];
        $this->loadLayout('crm/quotations', $data);
    }
}

// CRM Sales Orders (maps to /crm_sales_order)
class Crm_sales_order extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Sales Orders',
            'sales_orders' => [],
        ];
        $this->loadLayout('crm/sales_orders', $data);
    }
}

// CRM Invoices listing (maps to /crm_invoices)
class Crm_invoices extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Invoices',
            'invoices' => [],
        ];
        $this->loadLayout('crm/invoices', $data);
    }
}

// CRM Projects listing (maps to /crm_projects)
class Crm_projects extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Projects',
            'projects' => [],
        ];
        $this->loadLayout('crm/projects', $data);
    }
}

// CRM Tasks listing (maps to /crm_tasks)
class Crm_tasks extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Tasks',
            'tasks' => [],
        ];
        $this->loadLayout('crm/tasks', $data);
    }
}

// CRM Activities log (maps to /crm_activities)
class Crm_activities extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Activities',
            'activities' => [],
        ];
        $this->loadLayout('crm/activities', $data);
    }
}

// CRM Timesheets listing (maps to /crm_timesheets)
class Crm_timesheets extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Timesheets',
            'timesheets' => [],
        ];
        $this->loadLayout('crm/timesheets', $data);
    }
}

// CRM Project View (maps to /crm_project_view/{id})
class Crm_project_view extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('crm_projects'); return; }

        $data = [
            'page_title' => 'Project Details',
            'project'    => null,
            'tasks'      => [],
            'team'       => [],
            'files'      => [],
            'timeline'   => [],
        ];

        if ($this->db) {
            $data['project'] = $this->db->fetchOne(
                "SELECT p.*, c.company_name as client_name FROM projects p LEFT JOIN companies c ON c.id = p.client_id WHERE p.id = ?",
                [$id]
            );
            $data['tasks'] = $this->db->fetchAll("SELECT * FROM tasks WHERE project_id = ? ORDER BY due_date ASC", [$id]);
            $data['team'] = $this->db->fetchAll(
                "SELECT u.* FROM team_members tm LEFT JOIN users u ON u.id = tm.user_id LEFT JOIN teams t ON t.id = tm.team_id WHERE t.client_id = (SELECT client_id FROM projects WHERE id = ?) LIMIT 20",
                [$id]
            );
            $data['files'] = $this->db->fetchAll(
                "SELECT * FROM documents WHERE entity_type = 'company' AND entity_id = (SELECT company_id FROM projects WHERE id = ?) ORDER BY created_at DESC",
                [$id]
            );
            $data['timeline'] = $this->db->fetchAll(
                "SELECT a.*, u.name as user_name FROM activities a LEFT JOIN users u ON u.id = a.user_id WHERE a.project_id = ? ORDER BY a.created_at DESC LIMIT 50",
                [$id]
            );
        }

        $this->loadLayout('crm/project_view', $data);
    }
}

// CRM Project Edit (maps to /crm_project_edit/{id})
class Crm_project_edit extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('crm_projects'); return; }

        $data = [
            'page_title' => 'Edit Project',
            'project'    => null,
            'clients'    => [],
            'users'      => [],
        ];

        if ($this->db) {
            $data['project'] = $this->db->fetchOne("SELECT * FROM projects WHERE id = ?", [$id]);
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['clients'] = $this->db->fetchAll("SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC", [$client->id]);
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? AND status = 'Active' ORDER BY name ASC", [$client->id]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->update('projects', [
                    'name'        => $this->input('project_name', ''),
                    'client_id'   => $this->input('client_id') ?: null,
                    'start_date'  => $this->input('start_date') ?: null,
                    'due_date'    => $this->input('due_date') ?: null,
                    'status'      => $this->input('status', 'Not Started'),
                    'budget'      => $this->input('budget', 0),
                    'priority'    => $this->input('priority', 'Medium'),
                    'description' => $this->input('description', ''),
                ], 'id = ?', [$id]);
                $this->setFlash('success', 'Project updated successfully.');
                $this->redirect("crm_project_view/{$id}");
                return;
            }
        }

        $this->loadLayout('crm/project_form', $data);
    }
}

// CRM Project Create (maps to /crm_project_create)
class Crm_project_create extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Create Project',
            'project'    => null,
            'clients'    => [],
            'users'      => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['clients'] = $this->db->fetchAll("SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC", [$client->id]);
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? AND status = 'Active' ORDER BY name ASC", [$client->id]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $projectId = $this->db->insert('projects', [
                    'name'        => $this->input('project_name', ''),
                    'client_id'   => $this->input('client_id') ?: null,
                    'start_date'  => $this->input('start_date') ?: null,
                    'due_date'    => $this->input('due_date') ?: null,
                    'status'      => $this->input('status', 'Not Started'),
                    'budget'      => $this->input('budget', 0),
                    'priority'    => $this->input('priority', 'Medium'),
                    'description' => $this->input('description', ''),
                    'created_by'  => $_SESSION['user_id'] ?? null,
                ]);
                $this->setFlash('success', 'Project created successfully.');
                $this->redirect("crm_project_view/{$projectId}");
                return;
            }
        }

        $this->loadLayout('crm/project_form', $data);
    }
}

// CRM Project Gantt (maps to /crm_project_gantt)
class Crm_project_gantt extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Project Gantt Chart',
            'projects'   => [],
            'tasks'      => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['projects'] = $this->db->fetchAll("SELECT * FROM projects WHERE client_id IN (SELECT id FROM companies WHERE client_id = ?) ORDER BY start_date ASC", [$client->id]);
                $data['tasks'] = $this->db->fetchAll("SELECT t.*, p.name as project_name FROM tasks t LEFT JOIN projects p ON p.id = t.project_id ORDER BY t.start_date ASC");
            }
        }

        $this->loadLayout('crm/gantt', $data);
    }
}

// CRM Create Quotation (maps to /crm_create_quotation)
class Crm_create_quotation extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Create Quotation',
            'clients'    => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['clients'] = $this->db->fetchAll("SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC", [$client->id]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $quotationId = $this->db->insert('quotations', [
                    'client_id'     => $this->input('client_id') ?: null,
                    'quotation_date'=> $this->input('quotation_date') ?: date('Y-m-d'),
                    'validity_date' => $this->input('validity_date') ?: null,
                    'total_amount'  => $this->input('total_amount', 0),
                    'notes'         => $this->input('notes', ''),
                    'terms'         => $this->input('terms', ''),
                    'status'        => 'Draft',
                    'created_by'    => $_SESSION['user_id'] ?? null,
                ]);

                // Save line items
                $items = $_POST['item_name'] ?? [];
                foreach ($items as $i => $itemName) {
                    if (empty($itemName)) continue;
                    $this->db->insert('quotation_items', [
                        'quotation_id' => $quotationId,
                        'item_name'    => $itemName,
                        'description'  => $_POST['item_description'][$i] ?? '',
                        'quantity'     => $_POST['item_qty'][$i] ?? 1,
                        'rate'         => $_POST['item_rate'][$i] ?? 0,
                        'amount'       => $_POST['item_amount'][$i] ?? 0,
                    ]);
                }

                $this->setFlash('success', 'Quotation created successfully.');
                $this->redirect('crm_quotations');
                return;
            }
        }

        $this->loadLayout('crm/quotation_form', $data);
    }
}

// CRM Create Sales Order (maps to /crm_create_order)
class Crm_create_order extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Create Sales Order',
            'clients'    => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['clients'] = $this->db->fetchAll("SELECT id, company_name FROM companies WHERE client_id = ? ORDER BY company_name ASC", [$client->id]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $orderId = $this->db->insert('sales_orders', [
                    'client_id'   => $this->input('client_id') ?: null,
                    'order_date'  => $this->input('order_date') ?: date('Y-m-d'),
                    'delivery_date'=> $this->input('delivery_date') ?: null,
                    'total_amount'=> $this->input('total_amount', 0),
                    'notes'       => $this->input('notes', ''),
                    'terms'       => $this->input('terms', ''),
                    'status'      => 'Draft',
                    'created_by'  => $_SESSION['user_id'] ?? null,
                ]);

                $items = $_POST['item_name'] ?? [];
                foreach ($items as $i => $itemName) {
                    if (empty($itemName)) continue;
                    $this->db->insert('order_items', [
                        'order_id'    => $orderId,
                        'item_name'   => $itemName,
                        'description' => $_POST['item_description'][$i] ?? '',
                        'quantity'    => $_POST['item_qty'][$i] ?? 1,
                        'rate'        => $_POST['item_rate'][$i] ?? 0,
                        'amount'      => $_POST['item_amount'][$i] ?? 0,
                    ]);
                }

                $this->setFlash('success', 'Sales order created successfully.');
                $this->redirect('crm_sales_order');
                return;
            }
        }

        $this->loadLayout('crm/order_form', $data);
    }
}

// CRM Follow-up List (maps to /crm_followup_list)
class Crm_followup_list extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Follow-up List',
            'followups'  => [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['followups'] = $this->db->fetchAll(
                    "SELECT f.*, l.lead_title as lead_name, l.contact_name
                     FROM followups f 
                     LEFT JOIN leads l ON l.id = f.lead_id 
                     WHERE f.client_id = ? 
                     ORDER BY f.followup_date DESC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('crm/followup_list', $data);
    }
}

// CRM Invoice Reconciliation (maps to /crm_invoice_reconciliation)
class Crm_invoice_reconciliation extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'     => 'Invoice Reconciliation',
            'reconciliations'=> [],
        ];

        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['reconciliations'] = $this->db->fetchAll(
                    "SELECT i.*, c.company_name, i.amount_paid as paid_amount 
                     FROM invoices i 
                     LEFT JOIN companies c ON c.id = i.company_id 
                     WHERE i.client_id = ? 
                     ORDER BY i.invoice_date DESC",
                    [$client->id]
                );
            }
        }

        $this->loadLayout('crm/invoice_reconciliation', $data);
    }
}

// CRM Ticket View (maps to /crm_ticket_view/{id})
class Crm_ticket_view extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('tickets'); return; }

        $data = [
            'page_title'  => 'Ticket Details',
            'ticket'      => null,
            'conversations'=> [],
        ];

        if ($this->db) {
            $data['ticket'] = $this->db->fetchOne(
                "SELECT t.*, u.name as created_by_name, a.name as assigned_to_name 
                 FROM tickets t 
                 LEFT JOIN users u ON u.id = t.created_by 
                 LEFT JOIN users a ON a.id = t.assigned_to 
                 WHERE t.id = ?",
                [$id]
            );
            $data['conversations'] = $this->db->fetchAll(
                "SELECT tc.*, u.name as user_name, u.profile_image 
                 FROM ticket_conversations tc 
                 LEFT JOIN users u ON u.id = tc.user_id 
                 WHERE tc.ticket_id = ? 
                 ORDER BY tc.created_at ASC",
                [$id]
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->validateCsrf() && $this->db) {
                $this->db->insert('ticket_conversations', [
                    'ticket_id' => $id,
                    'user_id'   => $_SESSION['user_id'] ?? null,
                    'message'   => $this->input('message', ''),
                ]);
                $this->setFlash('success', 'Reply posted successfully.');
                $this->redirect("crm_ticket_view/{$id}");
                return;
            }
        }

        $this->loadLayout('crm/ticket_view', $data);
    }
}

// Dashboard Activity (maps to /dashboard_activity)
class Dashboard_activity extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'  => 'Activity Dashboard',
            'activities'  => [],
            'stats'       => ['total' => 0, 'today' => 0, 'this_week' => 0, 'this_month' => 0],
        ];
        $this->loadLayout('crm/dashboard_activity', $data);
    }
}

// Dashboard Invoice (maps to /dashboard_invoice)
class Dashboard_invoice extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'    => 'Invoice Dashboard',
            'stats'         => ['total' => 0, 'paid' => 0, 'unpaid' => 0, 'overdue' => 0, 'revenue' => 0],
            'overdue_list'  => [],
        ];
        $this->loadLayout('crm/dashboard_invoice', $data);
    }
}

// Dashboard Project (maps to /dashboard_project)
class Dashboard_project extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title'      => 'Project Dashboard',
            'stats'           => ['total' => 0, 'active' => 0, 'completed' => 0, 'on_hold' => 0],
            'active_projects' => [],
        ];
        $this->loadLayout('crm/dashboard_project', $data);
    }
}

// Dashboard Leads (maps to /dashboard_leads)
class Dashboard_leads extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Leads Dashboard',
            'stats'      => ['total' => 0, 'new' => 0, 'qualified' => 0, 'converted' => 0, 'lost' => 0],
            'pipeline'   => [],
        ];
        $this->loadLayout('crm/dashboard_leads', $data);
    }
}

// Dashboard Support (maps to /dashboard_support)
class Dashboard_support extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = [
            'page_title' => 'Support Dashboard',
            'stats'      => ['total' => 0, 'open' => 0, 'closed' => 0, 'avg_response' => '0h'],
        ];
        $this->loadLayout('crm/dashboard_support', $data);
    }
}

// Lead Detail View (maps to /crm_lead_detail/{id})
class Crm_lead_detail extends BaseController {
    public function index($id = null) {
        $this->requireAuth();
        if (!$id) { $this->redirect('crm_leads'); return; }
        $data = ['page_title' => 'Lead Details', 'lead' => null, 'followups' => [], 'quotations' => [], 'activities' => []];
        if ($this->db) {
            $data['lead'] = $this->db->fetchOne(
                "SELECT l.*, ls.source_name, lst.status_name, lr.rating_name, u.name as assigned_to_name FROM leads l LEFT JOIN lead_sources ls ON ls.id = l.source_id LEFT JOIN lead_statuses lst ON lst.id = l.status_id LEFT JOIN lead_ratings lr ON lr.id = l.rating_id LEFT JOIN users u ON u.id = l.assigned_to WHERE l.id = ?", [$id]
            );
            $data['followups'] = $this->db->fetchAll(
                "SELECT f.*, fm.mode_name, fa.agenda_name FROM followups f LEFT JOIN followup_modes fm ON fm.id = f.followup_mode_id LEFT JOIN followup_agendas fa ON fa.id = f.followup_agenda_id WHERE f.lead_id = ? ORDER BY f.followup_date DESC", [$id]
            );
            $data['quotations'] = $this->db->fetchAll("SELECT * FROM quotations WHERE lead_id = ? ORDER BY quotation_date DESC", [$id]);
            $data['activities'] = $this->db->fetchAll(
                "SELECT ul.*, u.name as user_name FROM user_logs ul LEFT JOIN users u ON u.id = ul.user_id WHERE ul.module = 'lead' AND ul.record_id = ? ORDER BY ul.created_at DESC", [$id]
            );
        }
        $this->loadLayout('crm/lead_detail', $data);
    }
}

// CRM Team Creation (maps to /crm_team_creation)
class Crm_team_creation extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Team Management', 'teams' => [], 'users' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['teams'] = $this->db->fetchAll(
                    "SELECT t.*, u.name as leader_name, (SELECT COUNT(*) FROM team_members tm WHERE tm.team_id = t.id) as member_count FROM teams t LEFT JOIN users u ON u.id = t.leader_id WHERE t.client_id = ? ORDER BY t.team_name", [$client->id]
                );
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? AND status = 'Active' ORDER BY name", [$client->id]);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validateCsrf() && $this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $this->db->execute("INSERT INTO teams (client_id,team_name,leader_id,status) VALUES (?,?,?,?)", [
                    $client->id, $this->input('team_name',''), $this->input('leader_id',''), 'Active'
                ]);
                $this->setFlash('success', 'Team created.'); $this->redirect('crm_team_creation'); return;
            }
        }
        $this->loadLayout('crm/team_creation', $data);
    }
}

// Timesheet standalone (maps to /timesheet_weekly)
class Timesheet_weekly extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Weekly Timesheet', 'users' => [], 'timesheet_rows' => [], 'current_week' => $_GET['week'] ?? date('Y-\WW'), 'filter_user' => $_GET['user_id'] ?? ''];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? ORDER BY name", [$client->id]);
            }
        }
        $this->loadLayout('crm/timesheet_standalone', $data);
    }
}

// Timesheet Activity Report (maps to /timesheet_activity)
class Timesheet_activity extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Timesheet Activity', 'users' => [], 'projects' => [], 'activities' => [], 'filter_daterange' => $_GET['daterange'] ?? ''];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['users'] = $this->db->fetchAll("SELECT id, name FROM users WHERE client_id = ? ORDER BY name", [$client->id]);
                $data['projects'] = $this->db->fetchAll("SELECT id, project_name FROM projects WHERE client_id = ? ORDER BY project_name", [$client->id]);
                $data['activities'] = $this->db->fetchAll(
                    "SELECT ts.*, u.name as user_name, p.project_name, t.task_name FROM timesheets ts LEFT JOIN users u ON u.id = ts.user_id LEFT JOIN projects p ON p.id = ts.project_id LEFT JOIN tasks t ON t.id = ts.task_id WHERE ts.client_id = ? ORDER BY ts.date DESC LIMIT 500", [$client->id]
                );
            }
        }
        $this->loadLayout('crm/timesheet_activity', $data);
    }
}

// Workflow AGM Automation (maps to /workflow_agm)
class Workflow_agm extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'AGM Automation Workflow', 'unallocated' => [], 'allocated' => [], 'completed' => []];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['unallocated'] = $this->db->fetchAll(
                    "SELECT c.id, c.id as company_id, c.company_name, c.registration_number, c.next_agm_due as due_date FROM companies c WHERE c.client_id = ? AND c.next_agm_due IS NOT NULL AND c.entity_status = 'Active' ORDER BY c.next_agm_due ASC", [$client->id]
                );
            }
        }
        $this->loadLayout('crm/workflow', $data);
    }
}

// Invoice Settings (maps to /invoice_settings)
class Invoice_settings extends BaseController {
    public function index() {
        $this->requireAuth();
        $data = ['page_title' => 'Invoice Settings', 'settings' => (object)[]];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $data['settings'] = $this->db->fetchOne("SELECT * FROM invoice_settings WHERE client_id = ?", [$client->id]) ?: (object)[];
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validateCsrf() && $this->db) {
            $this->setFlash('success', 'Invoice settings saved.'); $this->redirect('invoice_settings'); return;
        }
        $this->loadLayout('crm/invoice_settings', $data);
    }
}
