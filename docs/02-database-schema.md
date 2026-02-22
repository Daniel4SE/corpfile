# Database Schema Documentation

**Database**: `corporate_secretary`  
**Engine**: MySQL 8.x / 9.x (InnoDB)  
**Total Tables**: 87  
**Schema File**: `database/schema.sql`  
**Seed Data**: `database/seed.sql`

## Entity Relationship Overview

```
clients (TENANT ROOT)
  ├── users ──── user_groups ──── user_group_permissions
  │              user_logs
  │              user_page_access
  │              teams ──── team_members
  │
  ├── companies
  │     ├── directors (→ members)
  │     ├── secretaries (→ members)
  │     ├── shareholders (→ members)
  │     ├── auditors
  │     ├── controllers
  │     ├── company_officials (generic 25+ types)
  │     ├── company_shares (allotments/transfers)
  │     ├── company_events (AGM/AR/Resolutions)
  │     ├── company_fees
  │     ├── company_bank_accounts
  │     ├── company_holding
  │     ├── company_groups
  │     ├── company_pic
  │     ├── sealings
  │     └── register_charges
  │
  ├── members
  │     └── member_identifications
  │
  ├── leads → followups
  ├── quotations
  ├── sales_orders
  ├── invoices → invoice_items
  ├── projects → tasks → task_checklists
  │              timesheets
  │              activities
  ├── tickets → ticket_conversations
  │
  ├── documents
  ├── esign_documents
  ├── notifications
  ├── reminders
  │
  └── settings_general (key-value config)
      email_templates
      form_templates
      invoice_settings
```

---

## Module 1: Clients (Tenant Root)

### `clients`
The root tenant table. Each row represents one corporate secretarial firm.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | Auto-increment ID |
| client_id | VARCHAR(20) UNIQUE | Company ID code (e.g., "YY244") |
| client_name | VARCHAR(255) | Firm name |
| email | VARCHAR(255) | Primary email |
| phone | VARCHAR(50) | Contact phone |
| address | TEXT | Office address |
| logo | VARCHAR(255) | Logo filename |
| singpass_enabled | TINYINT(1) | SingPass integration flag |
| status | VARCHAR(20) | Active/Inactive |
| created_at | DATETIME | Record creation timestamp |

**Key**: Nearly every other table has `client_id` FK pointing here for tenant isolation.

---

## Module 2: Companies (10 tables)

### `companies`
Core company entity with 100+ columns covering ACRA registration, share capital, FYE, service classifications, and more.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | Auto-increment |
| client_id | INT UNSIGNED FK | Tenant reference |
| company_name | VARCHAR(255) | Registered company name |
| registration_number | VARCHAR(50) | ACRA UEN |
| former_name | VARCHAR(255) | Previous company name |
| company_type_id | INT UNSIGNED FK | → company_types |
| entity_status | VARCHAR(50) | Live/Struck Off/etc. |
| date_of_incorporation | DATE | Incorporation date |
| country_of_incorporation | VARCHAR(100) | Default: Singapore |
| registered_address | TEXT | Registered office address |
| business_address | TEXT | Operating address |
| principal_activities | TEXT | Business activities (SSIC) |
| no_ord_shares | INT | Number of ordinary shares |
| ord_issued_share_capital | DECIMAL(20,2) | Issued share capital |
| ord_currency | VARCHAR(10) | Share capital currency |
| paid_up_capital | DECIMAL(20,2) | Paid-up capital |
| fye_month | INT | Financial year end month (1-12) |
| fye_day | INT | Financial year end day |
| is_css / is_tax / is_accounting / is_audit / is_payroll / ... | TINYINT(1) | 30+ service classification flags |
| agm_due_date | DATE | Next AGM due date |
| ar_due_date | DATE | Next annual return due date |
| created_at / updated_at | DATETIME | Timestamps |

### `company_types`
Lookup table for company entity types.
- `id`, `client_id`, `type_name`, `status`, `created_at`
- Examples: "Exempt Private Company Limited by Shares", "Sole-Proprietorship"

### `company_shares`
Share allotments, transfers, and capital changes per company.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | |
| company_id | INT UNSIGNED FK | → companies |
| shareholder_id | INT UNSIGNED FK | → shareholders |
| currency | VARCHAR(10) | Default: SGD |
| share_type | VARCHAR(50) | Ordinary/Preference |
| share_class_id | INT UNSIGNED FK | → share_classes |
| type | VARCHAR(50) | Allotment/Transfer |
| number_of_shares | INT | Share count |
| issued_share_capital | DECIMAL(20,2) | Capital amount |
| paid_up_capital | DECIMAL(20,2) | Paid-up amount |
| unpaid_capital | DECIMAL(20,2) | Unpaid amount |
| consideration | DECIMAL(20,2) | Transfer consideration |
| transaction_date | DATE | Date of transaction |

### `company_events`
AGM, Annual Return, Resolution, and other corporate events.
- `id`, `client_id`, `company_id`, `event_type`, `event_date`, `due_date`, `status`, `notes`, `filed_date`, `agm_held`, `ar_filed`, `created_at`

### `company_officials`
Generic officials table supporting 25+ officer types in a single table.
- `id`, `company_id`, `official_type` (Manager/Agent/Liquidator/etc.), `member_id`, `name`, `id_type`, `id_number`, `nationality`, `address`, `appointment_date`, `cessation_date`, `status`

### Other Company Tables
- **`company_fees`**: Fee schedule per company (`company_id`, `fee_type_id`, `amount`, `frequency`, `start_date`)
- **`company_bank_accounts`**: Bank accounts (`company_id`, `bank_id`, `account_name`, `account_number`, `currency`)
- **`company_holding`**: Holding/subsidiary relationships (`parent_company_id`, `child_company_id`, `percentage`)
- **`company_groups`**: Group categorization (`company_id`, `group_name`)
- **`company_pic`**: Person-in-charge assignment (`company_id`, `user_id`, `role`)

---

## Module 3: Members (3 tables)

### `members`
Individual persons who may serve as directors, shareholders, secretaries, etc.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | |
| client_id | INT UNSIGNED FK | Tenant |
| name | VARCHAR(255) | Full name |
| id_type | VARCHAR(50) | NRIC/Passport/FIN |
| id_number | VARCHAR(100) | ID number |
| nationality | VARCHAR(100) | |
| date_of_birth | DATE | |
| gender | VARCHAR(10) | |
| email | VARCHAR(255) | |
| contact_number | VARCHAR(50) | |
| local_address | TEXT | Singapore address |
| foreign_address | TEXT | Overseas address |
| alt_local_address | TEXT | Alternative SG address |
| alt_foreign_address | TEXT | Alternative overseas address |
| source_of_fund | VARCHAR(255) | KYC: source of funds |
| source_of_wealth | VARCHAR(255) | KYC: source of wealth |
| kyc_status | VARCHAR(50) | KYC verification status |
| pep_status | VARCHAR(50) | Politically Exposed Person status |
| created_at / updated_at | DATETIME | |

### `member_identifications`
Multiple ID documents per member.
- `id`, `member_id` FK, `id_type`, `id_number`, `issued_date`, `expired_date`, `issuing_country`, `file_path`

### `member_id_types`
Lookup: identification type names (NRIC, Passport, FIN, etc.)

---

## Module 4: Officials / Officers (5 tables)

### `directors`
Directors, CEOs, and contact persons.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | |
| company_id | INT UNSIGNED FK | |
| member_id | INT UNSIGNED FK | → members |
| director_type | ENUM | Individual/Corporate |
| position | VARCHAR(100) | Director/CEO/Contact Person |
| name, id_type, id_number, nationality, addresses... | Various | Denormalized from member |
| date_of_appointment | DATE | |
| date_of_cessation | DATE | |
| status | VARCHAR(20) | Active/Resigned/Removed |

### `secretaries`
Company secretaries (Individual or Corporate).
- Same structure as directors with `secretary_type` and corporate entity fields.

### `auditors`
Auditor appointments with firm details.
- `id`, `company_id`, `member_id`, `name`, `firm_name`, `firm_number`, `address`, `appointment_date`, `cessation_date`, `status`

### `controllers`
Registered controllers (for registrable controllers regime).
- `id`, `company_id`, `member_id`, `name`, `id_type`, `id_number`, `controller_type`, `appointment_date`, `status`

### `designations`
Lookup: designation/title names.

---

## Module 5: Shares / Shareholders (3 tables)

### `shareholders`
Individual or Corporate shareholders per company.
- Mirrors director structure with `shareholder_type` (Individual/Corporate)
- Corporate shareholders have `corp_*` fields (company type, reg address, incorporation date, etc.)

### `share_classes`
Lookup: share class types (Ordinary, Preference A/B, Management, etc.)

### `register_charges`
Register of charges (mortgages, debentures).
- `id`, `company_id`, `charge_type`, `chargee_name`, `amount`, `date_of_creation`, `date_of_satisfaction`

---

## Module 6: Events & Notifications (5 tables)

### `event_types`
Configurable event type definitions.
- `id`, `client_id`, `event_name`, `category`, `recurring_interval`, `status`

### `activities`
Activity log entries.
- `id`, `client_id`, `user_id`, `type`, `module`, `record_id`, `description`, `created_at`

### `reminders`
Reminder configuration rules.
- `id`, `client_id`, `reminder_name`, `reminder_type`, `days_before`, `email_template_id`, `status`

### `reminder_subjects`
Lookup: reminder subject categories.

### `notifications`
User notifications with read tracking.
- `id`, `client_id`, `user_id`, `title`, `message`, `type`, `link`, `is_read`, `created_at`

---

## Module 7: CRM (8 tables)

### `leads`
Sales leads with pipeline tracking.
- `id`, `client_id`, `lead_title`, `company_name`, `contact_person`, `email`, `phone`, `source_id` FK, `status_id` FK, `rating_id` FK, `assigned_to`, `expected_value`, `notes`, `created_at`

### `followups`
Follow-up activities on leads.
- `id`, `lead_id` FK, `user_id`, `mode_id` FK, `agenda_id` FK, `followup_date`, `next_followup_date`, `notes`

### `quotations`
Quotes with pricing.
- `id`, `client_id`, `lead_id`, `quotation_number`, `date`, `valid_until`, `subtotal`, `tax_rate`, `tax_amount`, `total`, `status`, `terms`

### `sales_orders`
Sales orders (may link to quotation).
- `id`, `client_id`, `quotation_id`, `order_number`, `date`, `subtotal`, `tax_amount`, `total`, `status`

### Lookup Tables
- **`lead_sources`**: Lead source channels
- **`lead_statuses`**: Pipeline stages with color codes
- **`lead_ratings`**: Lead quality ratings
- **`followup_agendas`**, **`followup_modes`**: Follow-up categorization
- **`market_segments`**: Market segment names

---

## Module 8: Billing / Finance (10 tables)

### `invoices`
Invoice header with payment tracking.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | |
| client_id | INT UNSIGNED FK | |
| company_id | INT UNSIGNED FK | |
| invoice_number | VARCHAR(50) | |
| invoice_date | DATE | |
| due_date | DATE | |
| subtotal | DECIMAL(15,2) | |
| tax_rate | DECIMAL(5,2) | |
| tax_amount | DECIMAL(15,2) | |
| total | DECIMAL(15,2) | |
| amount_paid | DECIMAL(15,2) | |
| balance | DECIMAL(15,2) | |
| status | VARCHAR(30) | Draft/Sent/Paid/Overdue |

### `invoice_items`
Line items per invoice.
- `id`, `invoice_id` FK, `description`, `quantity`, `unit_price`, `amount`, `fee_type_id`

### `invoice_settings`
Per-tenant invoice configuration.
- `id`, `client_id`, `prefix`, `next_number`, `tax_rate`, `payment_terms`, `bank_details`, `notes`

### Other Finance Tables
- **`fee_types`**: Fee catalog (`name`, `default_amount`, `category`)
- **`expense_heads`**: Expense categories
- **`payment_modes`**: Payment methods (Cash, Cheque, Transfer, etc.)
- **`banks`**: Bank list with SWIFT codes
- **`bank_transaction_approver_groups`**: Approval workflows (JSON `approvers`)
- **`account_types`**: Bank account types
- **`terms_conditions`**: Reusable T&C templates

---

## Module 9: Admin / Users / Teams (7 tables)

### `users`
User accounts with role-based access.

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED PK | |
| client_id | INT UNSIGNED FK | Tenant isolation |
| username | VARCHAR(100) | Login username |
| name | VARCHAR(255) | Display name |
| email | VARCHAR(255) | |
| password | VARCHAR(255) | bcrypt hash |
| role | ENUM | superadmin/admin/user/viewer |
| user_group_id | INT UNSIGNED FK | → user_groups |
| branch_id | INT UNSIGNED FK | → branches |
| phone | VARCHAR(50) | |
| profile_image | VARCHAR(255) | |
| status | VARCHAR(20) | Active/Inactive |
| last_login | DATETIME | |
| created_at | DATETIME | |

**Unique constraint**: `(client_id, username)`

### `user_groups`
Named permission groups.
- `id`, `client_id`, `group_name`, `description`, `status`

### `user_group_permissions`
CRUD permissions per module per group.
- `id`, `group_id` FK, `module_name`, `can_view`, `can_add`, `can_edit`, `can_delete`

### `user_logs`
Audit trail.
- `id`, `client_id`, `user_id`, `action`, `module`, `record_id`, `ip_address`, `user_agent`, `old_values` (JSON), `new_values` (JSON), `created_at`

### `user_page_access`
Per-user page-level access override.
- `id`, `user_id`, `page_key`, `can_access`

### `teams` / `team_members`
Team definitions and membership.
- `teams`: `id`, `client_id`, `team_name`, `leader_id`, `status`
- `team_members`: `id`, `team_id` FK, `user_id` FK, `role`

---

## Module 10: Tasks / Projects / Timesheets (8 tables)

### `projects`
Project management.
- `id`, `client_id`, `company_id`, `project_name`, `description`, `status_id` FK, `assigned_to`, `start_date`, `end_date`, `budget`, `created_at`

### `tasks`
Task items with assignment.
- `id`, `client_id`, `project_id` FK, `company_id`, `task_name`, `description`, `priority_id` FK, `status`, `assigned_to`, `due_date`, `group_id` FK, `created_at`

### `timesheets`
Time entries per user/task.
- `id`, `client_id`, `user_id`, `task_id` FK, `project_id` FK, `date`, `hours`, `description`

### Lookup Tables
- **`project_statuses`**: Status names with colors
- **`task_groups`**: Task grouping categories
- **`task_masters`**: Predefined task templates
- **`task_priorities`**: Priority levels with colors
- **`task_checklists`**: Checklist templates (JSON `items`)

---

## Module 11: Tickets / Support (5 tables)

### `tickets`
Support tickets.
- `id`, `client_id`, `subject`, `description`, `status`, `priority`, `type_id` FK, `source_id` FK, `assigned_to`, `created_by`, `company_id`, `due_date`, `closed_at`

### `ticket_conversations`
Threaded messages per ticket.
- `id`, `ticket_id` FK (CASCADE), `user_id`, `message`, `attachment`, `created_at`

### Lookup Tables
- **`ticket_priorities`**, **`ticket_sources`**, **`ticket_types`**

---

## Module 12: Settings / Templates / Documents (18 tables)

### `settings_general`
Key-value settings store per tenant.
- `id`, `client_id`, `setting_key`, `setting_group`, `setting_value`

### `email_templates`
Email templates with merge variables.
- `id`, `client_id`, `template_name`, `subject`, `body` (HTML), `category`, `status`

### `documents`
File upload records.
- `id`, `client_id`, `company_id`, `member_id`, `category_id` FK, `document_name`, `file_path`, `file_type`, `file_size`, `uploaded_by`, `created_at`

### `document_categories`
Hierarchical categories.
- `id`, `client_id`, `category_name`, `parent_id` (self-referencing FK)

### `esign_documents`
E-signature documents.
- `id`, `client_id`, `document_name`, `file_path`, `status`, `signers` (JSON), `created_by`, `created_at`

### `addresses`
Polymorphic address table.
- `id`, `addressable_type` (company/member), `addressable_id`, `type`, `block`, `street`, `floor`, `unit`, `building`, `postal_code`, `country`

### Other Lookup/Config Tables
- **`form_templates`**, **`form_categories`**: Document generation templates
- **`custom_fields`**: Dynamic fields per module
- **`branches`**: Office locations
- **`industries`**, **`regions`**: Classification lookups
- **`tags`**: Generic tagging
- **`status_master`**: Generic status definitions with colors
- **`cycle_masters`**: Cycle/frequency names
- **`group_master`**: Generic group definitions
- **`product_categories`**: Product categories
- **`uom_master`**: Units of measure
- **`register_footers`**: Footer text for printed registers
- **`sealings`**: Common seal usage register

---

## Seed Data Summary

The `seed.sql` file provides demo data for testing:

| Entity | Count |
|--------|------:|
| Clients | 1 (YY244) |
| Users | 6 |
| Companies | 15 |
| Members | 12 |
| Directors | 17 |
| Shareholders | 14 |
| Secretaries | 11 |
| Company Events (AGM) | 17 |
| Leads | 5 |
| Quotations | 3 |
| Invoices | 4 |
| Projects | 2 |
| Tasks | 5 |
| Settings master data | ~200 rows across lookup tables |
