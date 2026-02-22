# API / Routes Reference

## Overview

The application uses a custom router (`index.php`) with a **189-entry controller map** that maps flat URL segments to controller file + class pairs. There is no REST API; all routes serve rendered HTML pages (server-side rendering).

**Total Routes**: 189 mapped + fallback CI3-style routing  
**Controller Files**: 18  
**Controller Classes**: 109

## Route Resolution Order

The router processes incoming URIs through 4 phases:

### Phase 1: `settings/` Prefix
URLs starting with `/settings/` are handled specially:
1. Try `settings_<segment2>` as a map key
2. Try `<segment2>` directly as a map key
3. Fall through to Phase 3

Example: `/settings/company_fee_list/156` → key `settings_company_fee_list` → `Company_fee_list` class

### Phase 2: `report_module/` Prefix
URLs starting with `/report_module/` always dispatch to `Report_view` with remaining segments as params.

Example: `/report_module/register_of_director_list` → `Report_view::index('register_of_director_list')`

### Phase 3: Exact Map Match
First URL segment looked up in `$controllerMap`:
1. Case-sensitive match
2. Lowercase match

Example: `/company_list` → `Company_list` class in `Companies.php`

### Phase 4: Fallback CI3-Style
Classic `Controller/method/params` pattern for unmapped URLs.

Example: `/welcome/login` → `Welcome::login()`

---

## Complete Route Map by Module

### Authentication (`Welcome.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/welcome/login` | `Welcome` | `login()` | Login form (GET) / Authenticate (POST) |
| `/welcome/logout` | `Welcome` | `logout()` | Destroy session, redirect to login |
| `/welcome/forgot_password` | `Welcome` | `forgot_password()` | Password reset form |

### Dashboard (`Dashboard.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/dashboard` | `Dashboard` | `index()` | Main dashboard with stats, alerts, calendar |

### Companies (`Companies.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/company_list` | `Company_list` | `index()` | Company listing with DataTable |
| `/add_company` | `Add_company` | `index()` | 5-step company wizard (GET/POST) |
| `/view_company/{id}` | `View_company` | `index($id)` | Company detail with 16 tabs |
| `/edit_company/{id}` | `Edit_company` | `index($id)` | Edit company form (GET/POST) |
| `/pre_company` | `Pre_company` | `index()` | Pre-incorporation companies |
| `/post_company` | `Post_company` | `index()` | Post-incorporation companies |
| `/company_non_client` | `Company_non_client` | `index()` | Non-client companies |
| `/company_fee_list` | `Company_fee_list` | `index()` | Fee schedule listing |
| `/company_pdf/{id}` | `Company_pdf` | `index($id)` | Company profile PDF view |

**AJAX Endpoints** (via `Companies::__call`):
| URL | Method | Description |
|-----|--------|-------------|
| `/companies/get_files/{id}` | AJAX GET | List company files |
| `/companies/upload_file/{id}` | AJAX POST | Upload file to company |
| `/companies/delete_file/{id}` | AJAX POST | Delete company file |
| `/companies/get_activity_log/{id}` | AJAX GET | Company activity log |
| `/companies/officer_form/{type}/{id}` | AJAX GET | Dynamic officer form |
| `/companies/view_file/{id}` | AJAX GET | View file inline |
| `/companies/download_file/{id}` | AJAX GET | Download file |

### Members (`Members.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/member` | `Member_list` | `index()` | Member listing with DataTable |
| `/add_member` | `Add_member` | `index()` | Add member form (GET/POST) |
| `/view_member/{id}` | `View_member` | `index($id)` | Member detail with 7 tabs |
| `/edit_member/{id}` | `Edit_member` | `index($id)` | Edit member form (GET/POST) |

**AJAX Endpoints** (via `Members::__call`):
| URL | Method | Description |
|-----|--------|-------------|
| `/members/delete_member/{id}` | AJAX POST | Delete member |
| `/members/upload_file/{id}` | AJAX POST | Upload member file |
| `/members/delete_file/{id}` | AJAX POST | Delete member file |
| `/members/kyc_search` | AJAX GET | KYC search |

### Officials (`Officials.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/officials_list` | `Officials_list` | `index()` | Global officials listing (redirects to per-type) |
| `/company_officials/{id}` | `Company_officials` | `index($id)` | Per-company officials view (21 tabs) |
| `/add_director/{company_id}` | `Add_director` | `index($id)` | Add director form |
| `/add_shareholder/{company_id}` | `Add_shareholder` | `index($id)` | Add shareholder form |
| `/add_secretary/{company_id}` | `Add_secretary` | `index($id)` | Add secretary form |
| `/add_auditor/{company_id}` | `Add_auditor` | `index($id)` | Add auditor form |
| `/add_representative/{company_id}` | `Add_representative` | `index($id)` | Add representative form |
| `/add_manager/{company_id}` | `Add_manager` | `index($id)` | Add manager form |
| `/add_ceo/{company_id}` | `Add_ceo` | `index($id)` | Add CEO form |

### Events (`Events.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/event_tracker` | `Event_tracker` | `index()` | Event tracker dashboard |
| `/agm_listing` | `Agm_listing` | `index()` | AGM listing with DataTable |
| `/ar_listing` | `Ar_listing` | `index()` | Annual Return listing |
| `/fye_listing` | `Fye_listing` | `index()` | Financial Year End listing |
| `/anniversary_listing` | `Anniversary_listing` | `index()` | Anniversary listing |
| `/due_listing` | `Due_listing` | `index()` | Due dates listing |
| `/id_expiry_listing` | `Id_expiry_listing` | `index()` | ID expiry listing |
| `/company_agm_list/{id}` | `Company_agm_list` | `index($id)` | Per-company AGM list |
| `/add_agm` | `Add_agm` | `index()` | Add AGM form (redirects to list) |
| `/edit_agm/{id}` | `Edit_agm` | `index($id)` | Edit AGM form (GET/POST) |
| `/multiple_add_agm` | `Multiple_add_agm` | `index()` | Bulk add AGM form |
| `/duedatetracker` | `Event_tracker` | `index()` | Alias for event_tracker |

### Shares (`Shares.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/shares` | `Shares` | `index()` | Share management index |
| `/company_share_level/{id}` | `Company_share_level` | `index($id)` | Company share structure detail |
| `/discrepancy_company` | `Discrepancy_company` | `index()` | Share discrepancy report |
| `/partial_full_paid_discrepancy_company` | `Partial_full_paid_discrepancy_company` | `index()` | Partial/full paid discrepancy report |

### CRM (`Crm.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/crm` | `Crm` | `index()` | CRM redirect to dashboard |
| `/crm_dashboard` | `Crm_dashboard` | `index()` | CRM main dashboard |
| `/crm_leads` | `Crm_leads` | `index()` | Lead listing |
| `/add_lead` | `Add_lead` | `index()` | Add lead form |
| `/crm_quotations` | `Crm_quotations` | `index()` | Quotation listing |
| `/crm_sales_order` | `Crm_sales_order` | `index()` | Sales order listing |
| `/crm_invoices` | `Crm_invoices` | `index()` | Invoice listing |
| `/crm_projects` | `Crm_projects` | `index()` | Project listing |
| `/crm_project_view/{id}` | `Crm_project_view` | `index($id)` | Project detail view |
| `/crm_project_edit/{id}` | `Crm_project_edit` | `index($id)` | Edit project form |
| `/crm_project_create` | `Crm_project_create` | `index()` | Create project form |
| `/crm_project_gantt/{id}` | `Crm_project_gantt` | `index($id)` | Gantt chart view |
| `/crm_create_quotation` | `Crm_create_quotation` | `index()` | Create quotation form |
| `/crm_create_order` | `Crm_create_order` | `index()` | Create sales order form |
| `/crm_tasks` | `Crm_tasks` | `index()` | Task listing |
| `/crm_activities` | `Crm_activities` | `index()` | Activity listing |
| `/crm_timesheets` | `Crm_timesheets` | `index()` | Timesheet listing |
| `/crm_followup_list` | `Crm_followup_list` | `index()` | Follow-up listing |
| `/crm_invoice_reconciliation` | `Crm_invoice_reconciliation` | `index()` | Invoice reconciliation |
| `/crm_ticket_view/{id}` | `Crm_ticket_view` | `index($id)` | Ticket detail view |
| `/dashboard_activity` | `Dashboard_activity` | `index()` | Activity sub-dashboard |
| `/dashboard_invoice` | `Dashboard_invoice` | `index()` | Invoice sub-dashboard |
| `/dashboard_project` | `Dashboard_project` | `index()` | Project sub-dashboard |
| `/dashboard_leads` | `Dashboard_leads` | `index()` | Leads sub-dashboard |
| `/dashboard_support` | `Dashboard_support` | `index()` | Support sub-dashboard |

**CRM Route Aliases**:
- `/leads`, `/leads_listing` → `Crm_leads`
- `/leads_quotations` → `Crm_quotations`
- `/orders`, `/orders_listing` → `Crm_sales_order`
- `/tasks` → `Crm_tasks`
- `/activities` → `Crm_activities`
- `/timesheet` → `Crm_timesheets`
- `/twcrm_projects` → `Crm_projects`
- `/leads_followup_list` → `Crm_followup_list`
- `/Lead_dashboard` → `Dashboard_leads`
- `/crm_detail_company_lead` → `Crm_leads`

### Reports (`Reports.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/reports` | `Reports` | `index()` | Reports hub |
| `/css_reports` | `Css_reports` | `index()` | CSS module reports listing |
| `/crm_reports` | `Crm_reports` | `index()` | CRM module reports listing |
| `/report_view/{type}` | `Report_view` | `index($type)` | Reusable report template (87 types) |
| `/report_module/{type}` | `Report_view` | `index($type)` | Alias via prefix routing |

**87 Report Types** (passed as `$type` parameter):
Company listing, Director listing, Shareholder listing, Secretary listing, AGM report, AR report, FYE report, Anniversary report, Due date report, ID expiry report, Register of Directors, Register of Shareholders, Register of Secretaries, Share capital report, Fee report, and 70+ more.

### Settings (`Settings.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/settings` | `Settings` | `index()` | Settings hub (tabbed) |
| `/general_settings` | `General_settings` | `index()` | General settings form |
| `/user_settings` | `User_settings` | `index()` | User management settings |
| `/css_settings` | `Css_settings` | `index()` | CSS module settings |
| `/settings_master/{type}` | `Settings_master` | `index($type)` | Reusable master list (42 types) |
| `/settings_master_add/{type}` | `Settings_master_add` | `index($type)` | Add master item |
| `/settings_master_edit/{type}/{id}` | `Settings_master_edit` | `index($type, $id)` | Edit master item |

**42 Master List Types** (accessed via `/settings_master/{type}` or `/settings_{type}`):
company_type, branch_master, member_id_type_list, event_name_list, fee_type_list, document_category, email_template_list, payment_mode, industry_master, market_segment_master, region_master, custom_field, shares_class_type_list, register_footer_list, and 28 more.

### Admin / Users (`Admin.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/alladmin` | `Alladmin` | `index()` | Admin user listing |
| `/add_admin` | `Add_admin` | `index()` | Add admin user form (GET/POST) |
| `/edit_admin/{id}` | `Edit_admin` | `index($id)` | Edit admin user form (GET/POST) |
| `/page_access_rights/{user_id}` | `Page_access_rights` | `index($id)` | Page access rights editor |
| `/user_groups` | `User_groups` | `index()` | User groups listing |
| `/add_user_group` | `Add_user_group` | `index()` | Add user group form |
| `/edit_user_group/{id}` | `Edit_user_group` | `index($id)` | Edit user group form |
| `/user_groups_permissions` | `User_groups_permissions` | `index()` | Group permissions editor |
| `/change_psd` | `Change_psd` | `index()` | Change password form |

### Misc (`Misc.php`)

| URL | Class | Method | Description |
|-----|-------|--------|-------------|
| `/my_profile` | `My_profile` | `index()` | User profile page |
| `/sealings_list` | `Sealings_list` | `index()` | Sealings register |
| `/add_seal` | `Add_seal` | `index()` | Add sealing entry |
| `/company_bank` | `Company_bank` | `index()` | Company bank accounts listing |
| `/add_company_bank` | `Add_company_bank` | `index()` | Add bank account form |
| `/reminder_list` | `Reminder_list` | `index()` | Reminders listing |
| `/set_reminder` | `Set_reminder` | `index()` | Create reminder form |
| `/edit_reminder/{id}` | `Edit_reminder` | `index($id)` | Edit reminder form |
| `/esign_settings` | `Esign_settings` | `index()` | eSign settings page |
| `/esign_log` | `Esign_log` | `index()` | eSign audit log |
| `/member_pdf/{id}` | `Member_pdf` | `index($id)` | Member PDF view |
| `/member_documents/{id}` | `Member_documents` | `index($id)` | Member documents page |

### Other Modules

| URL | Class | File | Description |
|-----|-------|------|-------------|
| `/documents` | `Documents` | `Documents.php` | Document management |
| `/templates` | `Templates` | `Templates.php` | Document templates |
| `/esign` | `Esign` | `Templates.php` | eSign management |
| `/registers` | `Registers` | `Registers.php` | Register index |
| `/register_directors` | `Register_directors` | `Registers.php` | Register of Directors |
| `/register_shareholders` | `Register_shareholders` | `Registers.php` | Register of Shareholders |
| `/register_secretaries` | `Register_secretaries` | `Registers.php` | Register of Secretaries |
| `/support` | `Support` | `Support.php` | Support ticket listing |
| `/notifications` | `Notifications` | `Notifications.php` | Notification center |

### AJAX Controller (`Ajax.php`)

Standalone AJAX endpoint controller (581 lines) providing:
- Company AJAX operations
- Member AJAX operations
- Notification mark-all-read
- Generic CRUD operations
- File management operations

---

## Route Aliases Summary

Many routes have multiple URL aliases pointing to the same controller class. This mirrors the original system where different navigation paths lead to the same page:

| Primary URL | Aliases |
|-------------|---------|
| `/company_fee_list` | `/settings_company_fee_list` |
| `/company_pdf/{id}` | `/settings_view_company_pdf/{id}` |
| `/crm_leads` | `/leads`, `/leads_listing`, `/crm_detail_company_lead` |
| `/crm_quotations` | `/leads_quotations` |
| `/crm_sales_order` | `/orders`, `/orders_listing` |
| `/crm_tasks` | `/tasks` |
| `/crm_activities` | `/activities` |
| `/crm_timesheets` | `/timesheet` |
| `/crm_projects` | `/twcrm_projects` |
| `/crm_followup_list` | `/leads_followup_list` |
| `/dashboard_leads` | `/Lead_dashboard` |
| `/alladmin` | `/settings_admin_access_list` |
| `/page_access_rights` | `/settings_page_access_rights`, `/settings_lead_access_rights`, `/settings_task_ticket_access_rights` |
| `/user_groups` | `/settings_user_groups`, `/crm_team_creation` |
| `/company_bank` | `/mainadmin_company_bank`, `/bank` |
| `/sealings_list` | `/Sealings_sealings_list`, `/Sealings_reg_address_list`, `/settings_register_charge_list` |
| `/reminder_list` | `/Remainder_remainder_list` |
| `/member_pdf` | `/settings_view_member_pdf` |
| `/member_documents` | `/mainadmin_view_member_document` |
