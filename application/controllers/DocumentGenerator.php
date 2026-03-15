<?php
require_once APPPATH . 'libraries/AiBridge.php';

/**
 * Document Generator Controller
 * Handles: /document_generator
 * 
 * Provides template-based document generation for corporate secretarial work.
 * Categories: ACRA Registers, Company Resolutions, Annual Filings, Forms, Reports
 */
class DocumentGenerator extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $companies = [];
        if ($this->db) {
            $clientId = $_SESSION['client_id'] ?? '';
            $client = $this->db->fetchOne("SELECT id FROM clients WHERE client_id = ?", [$clientId]);
            if ($client) {
                $companies = $this->db->fetchAll(
                    "SELECT id, company_name, registration_number FROM companies WHERE client_id = ? ORDER BY company_name",
                    [$client->id]
                );
            }
        }

        $data = [
            'page_title' => 'Document Generator',
            'companies' => $companies,
        ];
        $this->loadLayout('documents/generator', $data);
    }

    /**
     * Generate a document from template
     * POST /document_generator/generate
     */
    public function generate() {
        $this->requireAuth();
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        // Flush headers early so proxy knows connection is alive
        header('Content-Type: application/json');
        header('X-Accel-Buffering: no');
        if (function_exists('ob_implicit_flush')) { ob_implicit_flush(true); }
        if (ob_get_level()) { ob_end_flush(); }

        $templateId    = $this->input('template_id', '');
        $companyId     = $this->input('company_id', '');
        $extraContext  = $this->input('extra_context', '');
        
        if (empty($templateId)) {
            echo json_encode(['success' => false, 'message' => 'Template ID required']);
            return;
        }

        // Get company data if provided
        $company = null;
        $directors = [];
        $shareholders = [];
        $secretary = null;
        
        if ($companyId && $this->db) {
            try {
                $company = $this->db->fetchOne("SELECT * FROM companies WHERE id = ?", [$companyId]);
            } catch (\Exception $e) { $company = null; }
            try {
                $directors = $this->db->fetchAll(
                    "SELECT d.*, m.name as member_name, m.id_number, m.nationality, m.email, m.address 
                     FROM directors d 
                     LEFT JOIN members m ON m.id = d.member_id 
                     WHERE d.company_id = ? AND (d.status = 'Active' OR d.status IS NULL)",
                    [$companyId]
                );
            } catch (\Exception $e) { $directors = []; }
            try {
                $shareholders = $this->db->fetchAll(
                    "SELECT s.*, m.name as member_name, m.id_number, m.nationality, m.email, m.address 
                     FROM shareholders s 
                     LEFT JOIN members m ON m.id = s.member_id 
                     WHERE s.company_id = ? AND (s.status = 'Active' OR s.status IS NULL)",
                    [$companyId]
                );
            } catch (\Exception $e) { $shareholders = []; }
            try {
                $secretary = $this->db->fetchOne(
                    "SELECT * FROM secretaries WHERE company_id = ? AND (status = 'Active' OR status IS NULL) LIMIT 1",
                    [$companyId]
                );
            } catch (\Exception $e) { $secretary = null; }
        }

        // Build context for AI generation
        $context = $this->buildTemplateContext($templateId, $company, $directors, $shareholders, $secretary, $extraContext);
        
        // Use AI to generate the document
        try {
            $aiBridge = new AiBridge();
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'AI service unavailable']);
            return;
        }

        $result = $aiBridge->runTurn($context['prompt'], [
            'system_prompt' => $context['system'],
            'max_tokens' => 8192,
            'temperature' => 0.2,
            'timeout' => 180,
        ]);

        if (!empty($result['ok']) && !empty($result['response_text'])) {
            echo json_encode([
                'success' => true,
                'content' => $result['response_text'],
                'template_name' => $context['name'],
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['error'] ?? 'Generation failed']);
        }
    }

    /**
     * Build the prompt context for a given template.
     * Uses specialized system prompts from DocumentPrompts where available,
     * and structured JSON data injection for the user turn.
     */
    private function buildTemplateContext($templateId, $company, $directors, $shareholders, $secretary, $extraContext = '') {
        require_once APPPATH . 'libraries/DocumentPrompts.php';

        $templates = $this->getTemplateDefinitions();
        $tpl = $templates[$templateId] ?? null;
        $tplName = $tpl ? $tpl['name'] : 'Corporate Document';

        // Try to get specialized system prompt
        $specializedPrompt = DocumentPrompts::getSystemPrompt($templateId);
        $genericSystem = "You are a Singapore corporate secretary document generator. Generate professional, legally-formatted documents. Use proper Singapore corporate law formatting and terminology. Include all standard legal clauses. Use today's date where needed. Format with clear sections and proper spacing.";
        $system = $specializedPrompt ?: $genericSystem;

        // Build structured JSON data payload for the user turn
        $jsonPayload = $this->buildDataPayload($company, $directors, $shareholders, $secretary);

        if ($specializedPrompt) {
            // For specialized prompts: send structured JSON as the user message
            $prompt = "Generate the following document: **{$tplName}**\n\nHere is the company data from CorpFile database:\n\n```json\n" . json_encode($jsonPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n```\n\nToday's date: " . date('Y-m-d') . "\n\nPlease generate the complete document with all required sections.";
        } else {
            // For generic templates: use the template instruction + flat text
            $companyInfo = $this->buildFlatCompanyInfo($company, $directors, $shareholders, $secretary);
            $instruction = $tpl ? $tpl['instruction'] : 'Generate a corporate document.';
            $prompt = "Generate the following document: **{$tplName}**\n\n{$instruction}\n\nCompany Information:\n{$companyInfo}";
        }

        // Append user-provided extra context from wizard fields
        if (!empty($extraContext)) {
            $prompt .= "\n\nAdditional details provided by user:\n" . $extraContext;
        }

        return ['name' => $tplName, 'system' => $system, 'prompt' => $prompt];
    }

    /**
     * Build the structured JSON data payload matching the SYSTEM DATA INJECTION spec.
     */
    private function buildDataPayload($company, $directors, $shareholders, $secretary) {
        if (!$company) {
            return ['company' => null, 'directors' => [], 'shareholders' => [], 'secretary' => null];
        }

        // Get registered address
        $address = null;
        if ($this->db) {
            try {
                $addr = $this->db->fetchOne(
                    "SELECT * FROM addresses WHERE entity_type = 'company' AND entity_id = ? AND (is_default = 1 OR address_type = 'Registered Office') LIMIT 1",
                    [$company->id]
                );
                if ($addr) {
                    $address = trim(implode(', ', array_filter([
                        $addr->block ?? '', $addr->address_text ?? '', $addr->building ?? '',
                        $addr->level ? '#' . $addr->level : '', $addr->unit ? '-' . $addr->unit : '',
                        $addr->postal_code ?? '', $addr->country ?? ''
                    ])));
                }
            } catch (\Exception $e) {}
        }

        // Get auditor
        $auditor = null;
        if ($this->db) {
            try {
                $aud = $this->db->fetchOne("SELECT * FROM auditors WHERE company_id = ? AND status = 'Active' LIMIT 1", [$company->id]);
                if ($aud) {
                    $auditor = [
                        'firm' => $aud->firm_name ?? $aud->name ?? null,
                        'partner' => $aud->name ?? null,
                        'appointed_date' => $aud->date_of_appointment ?? null,
                    ];
                }
            } catch (\Exception $e) {}
        }

        // Determine company type
        $totalShareholders = count($shareholders);
        $hasCorporateShareholder = false;
        foreach ($shareholders as $s) {
            if (($s->shareholder_type ?? '') === 'Corporate') {
                $hasCorporateShareholder = true;
                break;
            }
        }
        $isEPC = ($totalShareholders <= 20 && !$hasCorporateShareholder);
        $companyType = 'private';
        if ($isEPC) $companyType = 'exempt_private';

        return [
            'company' => [
                'uen' => $company->acra_registration_number ?? $company->registration_number ?? null,
                'name' => $company->company_name ?? null,
                'type' => $companyType,
                'incorporation_date' => $company->incorporation_date ?? null,
                'registered_address' => $address ?: null,
                'principal_activity' => $company->activity_1 ?? null,
                'principal_activity_description' => $company->activity_1_desc_default ?? null,
                'fye_date' => $company->fye_date ?? null,
                'is_small_company' => null,
                'is_dormant' => (($company->internal_css_status ?? '') === 'Dormant'),
                'entity_status' => $company->entity_status ?? 'Active',
                'last_ar_filed_date' => $company->last_ar_filing ?? null,
                'is_epc' => $isEPC,
                'total_shareholders' => $totalShareholders,
                'ord_issued_share_capital' => $company->ord_issued_share_capital ?? 0,
                'ord_currency' => $company->ord_currency ?? 'SGD',
                'no_ord_shares' => $company->no_ord_shares ?? 0,
                'paid_up_capital' => $company->paid_up_capital ?? 0,
            ],
            'directors' => array_map(function($d) {
                return [
                    'name' => $d->name ?? $d->member_name ?? null,
                    'nric' => $d->id_number ?? null,
                    'nationality' => $d->nationality ?? null,
                    'designation' => $d->role ?? 'director',
                    'appointed' => $d->date_of_appointment ?? $d->appointment_date ?? null,
                    'ceased' => $d->date_of_cessation ?? $d->cessation_date ?? null,
                    'email' => $d->email ?? null,
                    'status' => $d->status ?? 'Active',
                ];
            }, $directors),
            'shareholders' => array_map(function($s) use ($company) {
                $totalShares = (int)($company->no_ord_shares ?? 1);
                $shares = 0; // shares per shareholder not stored in shareholders table directly
                return [
                    'name' => $s->name ?? $s->member_name ?? null,
                    'id' => $s->id_number ?? null,
                    'type' => ($s->shareholder_type ?? 'Individual') === 'Corporate' ? 'corporation' : 'natural_person',
                    'nationality' => $s->nationality ?? null,
                    'appointed' => $s->date_of_appointment ?? null,
                    'ceased' => $s->date_of_cessation ?? null,
                    'status' => $s->status ?? 'Active',
                ];
            }, $shareholders),
            'secretary' => $secretary ? [
                'name' => $secretary->name ?? null,
                'appointed' => $secretary->date_of_appointment ?? null,
                'status' => $secretary->status ?? 'Active',
            ] : null,
            'auditor' => $auditor,
            'today' => date('Y-m-d'),
        ];
    }

    /**
     * Build flat text company info for generic templates (fallback).
     */
    private function buildFlatCompanyInfo($company, $directors, $shareholders, $secretary) {
        $companyName = $company->company_name ?? '[Company Name]';
        $regNo = $company->registration_number ?? $company->acra_registration_number ?? '[Registration No.]';
        $fyeDate = $company->fye_date ?? '[FYE Date]';
        $secretaryName = $secretary->name ?? '[Secretary Name]';

        $directorList = '';
        foreach ($directors as $d) {
            $name = $d->member_name ?? $d->name ?? 'Unknown';
            $directorList .= "- {$name} (ID: " . ($d->id_number ?? 'N/A') . ", Nationality: " . ($d->nationality ?? 'N/A') . ")\n";
        }
        $shareholderList = '';
        foreach ($shareholders as $s) {
            $name = $s->member_name ?? $s->name ?? 'Unknown';
            $shareholderList .= "- {$name} (Type: " . ($s->shareholder_type ?? 'Individual') . ")\n";
        }

        return "Company: {$companyName}\nUEN: {$regNo}\nFYE: {$fyeDate}\nSecretary: {$secretaryName}\n\nDirectors:\n{$directorList}\nShareholders:\n{$shareholderList}";
    }

    /**
     * All template definitions
     */
    private function getTemplateDefinitions() {
        return [
            // ─── ACRA Registers ──────────────────────────────────────
            'acra_register_directors' => [
                'name' => 'Register of Directors',
                'instruction' => 'Generate a Register of Directors in tabular format compliant with Section 173 of the Companies Act. Include columns for: Full Name, ID/Passport No., Nationality, Residential Address, Date of Appointment, Date of Cessation. List all current and past directors.',
            ],
            'acra_register_secretaries' => [
                'name' => 'Register of Secretaries',
                'instruction' => 'Generate a Register of Secretaries compliant with Section 171 of the Companies Act. Include: Full Name, ID/Passport No., Residential Address, Date of Appointment, Date of Cessation.',
            ],
            'acra_register_shareholders' => [
                'name' => 'Register of Members (Shareholders)',
                'instruction' => 'Generate a Register of Members/Shareholders compliant with Section 190 of the Companies Act. Include: Name, Address, ID/Passport No., No. of Shares, Class of Shares, Date of Entry, Date of Cessation.',
            ],
            'acra_register_charges' => [
                'name' => 'Register of Charges',
                'instruction' => 'Generate a Register of Charges compliant with Section 138 of the Companies Act. Include: Date of Creation, Short Description of Charge, Amount Secured, Names of Chargees, Date of Satisfaction/Release.',
            ],
            'acra_register_transfers' => [
                'name' => 'Register of Share Transfers',
                'instruction' => 'Generate a Register of Share Transfers. Include: Date of Transfer, Transferor Name, Transferee Name, No. of Shares Transferred, Class of Shares, Consideration, Certificate Nos.',
            ],
            'acra_register_allotments' => [
                'name' => 'Register of Share Allotments',
                'instruction' => 'Generate a Register of Share Allotments. Include: Date of Allotment, Allottee Name, No. of Shares Allotted, Class of Shares, Consideration per Share, Certificate Nos.',
            ],
            'acra_register_beneficial_owners' => [
                'name' => 'Register of Registrable Controllers',
                'instruction' => 'Generate a Register of Registrable Controllers (Beneficial Owners) compliant with Section 386AF of the Companies Act. Include: Name, ID No., Nationality, Residential Address, Date of Entry, Nature of Interest/Control.',
            ],
            'acra_register_nominee_directors' => [
                'name' => 'Register of Nominee Directors',
                'instruction' => 'Generate a Register of Nominee Directors compliant with Section 386AI of the Companies Act. Include: Nominee Director Name, ID No., Nominator Name, Nominator Address, Date of Entry, Date of Cessation.',
            ],
            'acra_register_auditors' => [
                'name' => 'Register of Auditors',
                'instruction' => 'Generate a Register of Auditors. Include: Audit Firm Name, Partner-in-Charge, Address, Date of Appointment, Date of Cessation, Financial Year Covered.',
            ],
            'acra_register_seals' => [
                'name' => 'Register of Seals',
                'instruction' => 'Generate a Register of Company Seals. Include: Date, Document Sealed, Parties, Authorized Signatories, Purpose/Description.',
            ],

            // ─── Company Resolutions ─────────────────────────────────
            'res_director_appointment' => [
                'name' => 'Resolution — Appointment of Director',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the appointment of a new director under Section 149 of the Companies Act. Include RESOLVED clauses, effective date, and proper attestation block.',
            ],
            'res_director_cessation' => [
                'name' => 'Resolution — Cessation of Director',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the resignation/cessation of a director. Include acceptance of resignation, effective date, and filing requirements.',
            ],
            'res_secretary_appointment' => [
                'name' => 'Resolution — Appointment of Secretary',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the appointment of a Company Secretary under Section 171 of the Companies Act.',
            ],
            'res_secretary_cessation' => [
                'name' => 'Resolution — Cessation of Secretary',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the cessation of a Company Secretary.',
            ],
            'res_change_address' => [
                'name' => 'Resolution — Change of Registered Address',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the change of registered office address under Section 142 of the Companies Act. Include old address, new address, and effective date.',
            ],
            'res_change_name' => [
                'name' => 'Resolution — Change of Company Name',
                'instruction' => 'Generate a Special Resolution for the change of company name under Section 28 of the Companies Act. Include the existing name, proposed new name, and authorization for filing.',
            ],
            'res_change_fye' => [
                'name' => 'Resolution — Change of Financial Year End',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the change of Financial Year End date. Include current FYE, new FYE, reasons, and filing requirements.',
            ],
            'res_share_allotment' => [
                'name' => 'Resolution — Allotment of Shares',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the allotment and issuance of new shares. Include number of shares, class, consideration, allottees, and payment terms.',
            ],
            'res_share_transfer' => [
                'name' => 'Resolution — Approval of Share Transfer',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the approval of a share transfer. Include transferor, transferee, number of shares, consideration, and waiver of pre-emptive rights if applicable.',
            ],
            'res_dividend_declaration' => [
                'name' => 'Resolution — Declaration of Dividend',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the declaration and payment of dividends. Include dividend type (interim/final), amount per share, record date, payment date, and total payout.',
            ],
            'res_open_bank_account' => [
                'name' => 'Resolution — Opening of Bank Account',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the opening of a corporate bank account. Include bank name, account type, authorized signatories, and signing authority.',
            ],
            'res_close_bank_account' => [
                'name' => 'Resolution — Closing of Bank Account',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the closing of a corporate bank account. Include bank name, account number, reason, and authorization to transfer remaining funds.',
            ],
            'res_authorize_signatory' => [
                'name' => 'Resolution — Change of Authorized Signatories',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the change of authorized bank signatories. Include outgoing and incoming signatories, and signing authority structure.',
            ],
            'res_auditor_appointment' => [
                'name' => 'Resolution — Appointment of Auditor',
                'instruction' => 'Generate a Directors\' Resolution in Writing for the appointment of auditors under Section 205 of the Companies Act. Include auditor firm name, partner-in-charge, and financial year.',
            ],
            'res_annual_general_meeting' => [
                'name' => 'Resolution — Convening AGM / Dispensation of AGM',
                'instruction' => 'Generate resolutions related to the Annual General Meeting — either a notice convening AGM with agenda items, or a resolution to dispense with AGM under Section 175A of the Companies Act for private companies exempt from audit.',
            ],
            'res_striking_off' => [
                'name' => 'Resolution — Application for Striking Off',
                'instruction' => 'Generate a Special Resolution and Directors\' Declaration for the application to strike off the company under Section 344 of the Companies Act. Include confirmation that the company has no assets/liabilities, no outstanding charges, and all members consent.',
            ],

            // ─── Annual Filings ──────────────────────────────────────
            'af_annual_return' => [
                'name' => 'Annual Return Preparation',
                'instruction' => 'Generate an Annual Return data summary for filing with ACRA. Include all required fields: company details, share capital structure, directors, secretary, shareholders, registered office, auditor details, and AGM date.',
            ],
            'af_agm_notice' => [
                'name' => 'Notice of Annual General Meeting',
                'instruction' => 'Generate a formal Notice of AGM. Include: date, time, venue, agenda items (financial statements, directors\' report, auditor appointment, declaration of dividend if applicable), proxy form notice.',
            ],
            'af_agm_minutes' => [
                'name' => 'Minutes of Annual General Meeting',
                'instruction' => 'Generate Minutes of AGM. Include: attendees, quorum confirmation, chairman appointment, adoption of financial statements, directors\' report, re-election of directors, auditor re-appointment, dividend declaration, any other business, closure.',
            ],
            'af_directors_report' => [
                'name' => 'Directors\' Report',
                'instruction' => 'Generate a Directors\' Report for attachment to financial statements. Include: principal activities, financial results summary, dividends, directors in office, directors\' interests in shares, auditor appointment.',
            ],
            'af_directors_statement' => [
                'name' => 'Directors\' Statement',
                'instruction' => 'Generate a Directors\' Statement under Section 201 of the Companies Act. Include: opinion on true and fair view of financial statements, reasonable expectation of solvency, signed by at least two directors.',
            ],
            'af_exempt_private_company' => [
                'name' => 'Declaration of Exempt Private Company (EPC)',
                'instruction' => 'Generate a declaration confirming the company qualifies as an Exempt Private Company under the Companies Act — no more than 20 shareholders, all individuals, no corporate shareholders.',
            ],
            'af_dormant_company_resolution' => [
                'name' => 'Dormant Company Exemption Resolution',
                'instruction' => 'Generate a resolution declaring the company dormant and exempt from audit requirements under Section 205C of the Companies Act.',
            ],
            'af_solvency_statement' => [
                'name' => 'Declaration of Solvency',
                'instruction' => 'Generate a Declaration of Solvency by directors confirming the company is able to pay its debts in full within 12 months. Required for voluntary winding up under Section 293 of the Companies Act.',
            ],

            // ─── Forms ───────────────────────────────────────────────
            'form_consent_director' => [
                'name' => 'Consent to Act as Director',
                'instruction' => 'Generate a Consent to Act as Director form under Section 145 of the Companies Act. Include: full name, ID/passport, nationality, residential address, declaration of no disqualification, date and signature block.',
            ],
            'form_consent_secretary' => [
                'name' => 'Consent to Act as Secretary',
                'instruction' => 'Generate a Consent to Act as Secretary form. Include full name, ID, qualifications, declaration, date and signature block.',
            ],
            'form_resignation_director' => [
                'name' => 'Director Resignation Letter',
                'instruction' => 'Generate a formal resignation letter from a director. Include: effective date, acknowledgment of filing obligations, handover notes.',
            ],
            'form_resignation_secretary' => [
                'name' => 'Secretary Resignation Letter',
                'instruction' => 'Generate a formal resignation letter from a company secretary. Include effective date and transition notes.',
            ],
            'form_share_transfer' => [
                'name' => 'Share Transfer Form (Instrument of Transfer)',
                'instruction' => 'Generate a Share Transfer Instrument. Include: transferor details, transferee details, number and class of shares, consideration, stamp duty reference, and signature blocks for both parties.',
            ],
            'form_proxy' => [
                'name' => 'Proxy Form for General Meeting',
                'instruction' => 'Generate a Proxy Form for use at a general meeting. Include: company name, meeting date, member details, proxy details, resolution voting instructions, and signature block.',
            ],
            'form_statutory_declaration' => [
                'name' => 'Statutory Declaration (Section 13 Compliance)',
                'instruction' => 'Generate a Statutory Declaration for company incorporation confirming compliance with Section 13 of the Companies Act.',
            ],
            'form_nominee_declaration' => [
                'name' => 'Nominee Director Declaration',
                'instruction' => 'Generate a Nominee Director Declaration form disclosing the nominator\'s details as required under Section 386AH of the Companies Act.',
            ],
            'form_register_controller_notice' => [
                'name' => 'Notice to Registrable Controller',
                'instruction' => 'Generate a notice to a registrable controller (beneficial owner) requesting information under Section 386AC of the Companies Act.',
            ],
            'form_change_particulars' => [
                'name' => 'Notice of Change of Particulars',
                'instruction' => 'Generate a Notice of Change of Particulars for a director/secretary/member (e.g., change of residential address, name, ID). Include old and new details.',
            ],
            'form_waiver_preemptive' => [
                'name' => 'Waiver of Pre-emptive Rights',
                'instruction' => 'Generate a Waiver of Pre-emptive Rights letter signed by existing shareholders consenting to the allotment of new shares without being offered first.',
            ],
            'form_indemnity_lost_cert' => [
                'name' => 'Letter of Indemnity — Lost Share Certificate',
                'instruction' => 'Generate a Letter of Indemnity for a lost share certificate, indemnifying the company against claims arising from the issuance of a replacement certificate.',
            ],

            // ─── Reports ─────────────────────────────────────────────
            'report_css' => [
                'name' => 'CSS Reports (24 Report Types)',
                'instruction' => '__REDIRECT__:/css_reports',
            ],
            'report_crm' => [
                'name' => 'CRM Reports (12 Report Types)',
                'instruction' => '__REDIRECT__:/crm_reports',
            ],
            'report_company_list' => [
                'name' => 'Company List Report',
                'instruction' => '__REDIRECT__:/report_view/official_contact_address',
            ],
            'report_director' => [
                'name' => 'Director Report',
                'instruction' => '__REDIRECT__:/report_view/comp_director_report',
            ],
            'report_shareholder' => [
                'name' => 'Shareholder Report',
                'instruction' => '__REDIRECT__:/report_view/default_shareholder',
            ],
            'report_secretary' => [
                'name' => 'Secretary Report',
                'instruction' => '__REDIRECT__:/report_view/comp_secretary_default',
            ],
            'report_agm' => [
                'name' => 'AGM Report',
                'instruction' => '__REDIRECT__:/report_view/agm_overdue',
            ],
            'report_ar' => [
                'name' => 'Annual Return Report',
                'instruction' => '__REDIRECT__:/report_view/key_dates',
            ],
            'report_fye' => [
                'name' => 'FYE Report',
                'instruction' => '__REDIRECT__:/report_view/remainder_upcoming_event',
            ],
            'report_share_capital' => [
                'name' => 'Share Capital Report',
                'instruction' => '__REDIRECT__:/report_view/register_of_shares_allotment',
            ],
            'report_registered_address' => [
                'name' => 'Registered Address Report',
                'instruction' => '__REDIRECT__:/report_view/registered_office_default',
            ],
            'report_auditor' => [
                'name' => 'Auditor Report',
                'instruction' => '__REDIRECT__:/report_view/register_of_auditors',
            ],
        ];
    }
}
