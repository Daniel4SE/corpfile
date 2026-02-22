# System Architecture Overview

## 1. Introduction

**TeamWork Corporate Secretarial System** is a multi-tenant enterprise web application for Singapore corporate secretarial firms. It manages companies, directors/shareholders/secretaries, AGM/AR filings, share structures, CRM, billing, and compliance tracking.

- **Original System**: https://login.teamwork.sg/ (PHP CodeIgniter 3, Apache, MySQL, AWS)
- **This Clone**: Standalone PHP MVC application (CI3-style), MySQL, PHP built-in server or Apache

## 2. Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Language | PHP | 8.x |
| Database | MySQL | 8.x / 9.x |
| Framework | Custom MVC (CodeIgniter 3-style) | - |
| Frontend CSS | Bootstrap 3 (Gentelella Admin Theme) | 3.3.7 |
| Frontend JS | jQuery, DataTables, Select2, FullCalendar, SweetAlert2, Switchery | Various |
| Icons | Font Awesome | 4.7.0 |
| Web Server | PHP built-in server (dev) / Apache (prod) | - |
| File Storage | Local filesystem (`uploads/`) | - |

## 3. Project Directory Structure

```
teamwork-demo/
├── index.php                    # Entry point + router (390 lines, 189 routes)
├── router.php                   # PHP built-in dev server static file router
├── .htaccess                    # Apache mod_rewrite rules
│
├── database/
│   ├── schema.sql               # Complete MySQL schema (87 tables)
│   └── seed.sql                 # Demo seed data (602 lines)
│
├── application/
│   ├── config/
│   │   ├── config.php           # App configuration (base_url, session, etc.)
│   │   ├── database.php         # Database connection settings
│   │   └── routes.php           # Route configuration
│   │
│   ├── libraries/               # Core framework (4 files, 294 lines)
│   │   ├── Controller.php       # BaseController (auth, views, CSRF, flash messages)
│   │   ├── Database.php         # PDO wrapper with CRUD helpers
│   │   ├── Model.php            # BaseModel with generic CRUD
│   │   └── Auth.php             # Authentication (login/logout/session)
│   │
│   ├── models/                  # Data models (2 files, 227 lines)
│   │   ├── Company_model.php    # Company queries + related data
│   │   └── Member_model.php     # Member queries + related data
│   │
│   ├── controllers/             # Route handlers (18 files, 6,388 lines, 109 classes)
│   │   ├── Welcome.php          # Login / Logout / Forgot Password
│   │   ├── Dashboard.php        # Main dashboard
│   │   ├── Companies.php        # Company CRUD + AJAX (835 lines, 10 classes)
│   │   ├── Members.php          # Member CRUD + AJAX (510 lines, 5 classes)
│   │   ├── Officials.php        # Officer management for 21 types (620 lines, 8 classes)
│   │   ├── Events.php           # Event tracker + AGM CRUD (520 lines, 11 classes)
│   │   ├── Shares.php           # Share structure + discrepancies (143 lines, 4 classes)
│   │   ├── Crm.php              # Full CRM module (556 lines, 25 classes)
│   │   ├── Reports.php          # Reports + reusable template (538 lines, 4 classes)
│   │   ├── Settings.php         # Settings + master CRUD (910 lines, 7 classes)
│   │   ├── Admin.php            # User/admin management (425 lines, 10 classes)
│   │   ├── Misc.php             # Profile, sealings, bank, reminders, eSign (425 lines, 13 classes)
│   │   ├── Ajax.php             # Standalone AJAX endpoint controller (581 lines)
│   │   ├── Documents.php        # Document management
│   │   ├── Templates.php        # Templates + eSign
│   │   ├── Registers.php        # Register of Directors/Shareholders/Secretaries
│   │   ├── Support.php          # Support tickets
│   │   └── Notifications.php    # Notification center
│   │
│   └── views/                   # PHP view templates (88 files, 18,507 lines)
│       ├── layouts/main.php     # Master admin layout (sidebar + topnav, 550 lines)
│       ├── auth/                # Login page
│       ├── dashboard/           # Dashboard with stats + calendar
│       ├── companies/           # 9 views (list, add wizard, edit, view with 16 tabs)
│       ├── members/             # 4 views (list, add, edit, view with 7 tabs)
│       ├── officials/           # 3 views (list, per-company view, reusable add form)
│       ├── events/              # 11 views (tracker, 6 listing types, AGM CRUD)
│       ├── shares/              # 4 views (index, company detail, 2 discrepancy reports)
│       ├── crm/                 # 23 views (dashboard, leads, quotations, projects, etc.)
│       ├── reports/             # 4 views (index, CSS reports, CRM reports, template)
│       ├── settings/            # 5 views (hub, general, users, master list/form)
│       ├── admin/               # 7 views (list, add, edit, groups, permissions, password)
│       ├── misc/                # 11 views (profile, sealings, bank, reminders, eSign)
│       └── [5 more dirs]        # documents, templates, registers, support, notifications
│
├── public/                      # Static assets (44 files, all real - no stubs)
│   ├── css/                     # custom.css, custom.min.css
│   ├── js/                      # custom.js, custom_event.js, jquery-resizable.js
│   ├── images/                  # favicon, login background
│   └── vendors/                 # 17 vendor libraries (Bootstrap, jQuery, DataTables, etc.)
│
├── uploads/                     # User file uploads
│   ├── .htaccess                # Security: prevent PHP execution
│   ├── companies/
│   └── members/
│
└── scraped_pages/               # Original scraped data (576 HTML + screenshots + JSON)
```

## 4. Architecture Patterns

### 4.1 Multi-Class Controller Pattern

Unlike traditional MVC where each controller file has one class, this system uses **multiple classes per controller file**. Each class handles one route/page:

```php
// Companies.php contains 10 classes:
class Companies extends BaseController { ... }     // AJAX endpoints via __call
class Company_list extends BaseController { ... }   // GET /company_list
class Add_company extends BaseController { ... }    // GET/POST /add_company
class View_company extends BaseController { ... }   // GET /view_company/{id}
class Edit_company extends BaseController { ... }   // GET/POST /edit_company/{id}
// ... 5 more
```

**Rationale**: Mirrors the original CodeIgniter 3 system where flat URL segments map directly to class names.

### 4.2 Router Architecture

The router in `index.php` resolves URLs through **4 phases** in priority order:

1. **`settings/` prefix** -- `/settings/company_fee_list` tries `settings_company_fee_list` then `company_fee_list` in the map
2. **`report_module/` prefix** -- Always dispatches to `Report_view` with the sub-report as parameter
3. **Exact map match** -- Looks up first URL segment (case-sensitive, then lowercase) in the 189-entry `$controllerMap`
4. **Fallback CI3-style routing** -- `Controller/method/params` pattern for unmapped URLs

### 4.3 Reusable Template Pattern

Three view templates serve dozens of variations via configuration:

| Template | Serves | Mechanism |
|----------|--------|-----------|
| `reports/report_template.php` | 87 report types | Controller passes `$report_type` config with column definitions |
| `settings/master_list.php` + `master_form.php` | 42 settings CRUD pages | Controller passes table name, columns, labels |
| `officials/add_officer.php` | 21 officer types | Controller passes `$officer_type` with field configuration |

### 4.4 Multi-Tenant Architecture

The system supports multiple corporate secretarial firms (tenants):

```
clients (tenant root) → users, companies, members, settings, etc.
                         All tables have client_id FK
```

- `clients.client_id` is the Company ID (e.g., "YY244")
- Session stores `$_SESSION['client_id']` after login
- Every database query filters by `client_id`

### 4.5 Client-Side DataTables

All ~40+ data tables use **client-side DataTables** (no server-side AJAX pagination). PHP renders the full data into HTML `<table>` elements, then DataTables JS adds:
- Pagination
- Sorting (click column headers)
- Search filtering
- Export buttons (CSV, Excel, PDF, Print)

### 4.6 AJAX Endpoints

Only **23 AJAX endpoints** exist, concentrated in 4 areas:

| Area | Endpoints |
|------|-----------|
| Companies view | File upload/delete, activity log, officer forms (via `__call` magic) |
| Members view | Delete member, file upload/delete, KYC search |
| Notifications | Mark all read |
| Ajax controller | Standalone `Ajax.php` for misc operations |

## 5. Authentication Flow

1. User visits any page → `requireAuth()` checks `$_SESSION['user_id']`
2. If not authenticated → redirect to `/welcome/login`
3. Login form submits Company ID + Username + Password
4. `Auth.php` looks up `clients` table by Company ID, then `users` table by username
5. Password verified with `password_verify()` (bcrypt)
6. Session populated: `user_id`, `client_id`, `user_name`, `user_role`
7. **Demo mode fallback**: If DB is unavailable, accepts hardcoded credentials

## 6. CSRF Protection

- Token generated per-session and stored in `$_SESSION['csrf_token']`
- Injected as hidden field `<input type="hidden" name="csrf_token">` in all forms
- Verified in `validateCsrf()` on all POST handlers
- Layout passes `$csrf_token` to all views

## 7. Key Code Metrics

| Metric | Value |
|--------|------:|
| Total PHP files | 117 |
| Total lines of PHP | 25,550 |
| Controller files | 18 |
| Controller classes | 109 |
| View files | 88 |
| View lines | 18,507 |
| Database tables | 87 |
| Route map entries | 189 |
| Vendor libraries | 17 |
| Static asset files | 44 |

## 8. Frontend Architecture

### Admin Template
- **Gentelella** Bootstrap 3 admin theme
- Brand color: `#1D50A3` (blue) for table headers, buttons, accents
- Left sidebar with 20 collapsible menu sections
- Top navigation bar with user profile, notifications, search
- Responsive layout

### Key JS Libraries
| Library | Purpose |
|---------|---------|
| jQuery 3.x | DOM manipulation, AJAX |
| Bootstrap 3.3.7 | Grid, modals, tabs, dropdowns |
| DataTables 1.10 | Sortable/searchable/paginated tables |
| Select2 4.x | Searchable dropdowns |
| FullCalendar 3.x | Calendar widget on dashboard |
| SweetAlert2 | Confirmation dialogs |
| Switchery | Toggle switches |
| DateRangePicker | Date range selection |
| Moment.js | Date formatting |

## 9. Security Measures

- CSRF tokens on all forms
- Password hashing with bcrypt (`password_hash` / `password_verify`)
- PDO prepared statements for all database queries (no raw SQL interpolation)
- `.htaccess` in uploads directory prevents PHP execution
- Session-based authentication with `requireAuth()` on every page
- Input sanitization via `htmlspecialchars()` in views
