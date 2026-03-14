# CorpFile — Reports: Full Data Schema Specification
# Version 1.0 | CSS Reports (24 Types) + CRM Reports (12 Types)
# All monetary values in SGD unless stated otherwise

---

## Architecture Overview

All reports share a common query interface. Each report type maps to:
- A `ReportType` enum value
- A `ReportParams` input schema (what the user selects)
- A `ReportDataset` output schema (what the backend returns to the rendering layer)
- A `ReportMetadata` block (title, generated_at, generated_by, filters applied)

Database tables referenced are shown as `[TableName]` — align to your ORM models.

---

## Core Shared Types

```typescript
// ─────────────────────────────────────────────
// Shared Enums
// ─────────────────────────────────────────────

enum CompanyType {
  PRIVATE          = "private",
  PUBLIC           = "public",
  EXEMPT_PRIVATE   = "exempt_private",
  LLP              = "llp",
  FOREIGN_BRANCH   = "foreign_branch"
}

enum ComplianceStatus {
  COMPLIANT        = "compliant",       // All filings up to date
  DUE_SOON         = "due_soon",        // Deadline within 30 days
  OVERDUE          = "overdue",         // Past deadline
  NOT_APPLICABLE   = "not_applicable"   // Exempt or not required
}

enum ShareClass {
  ORDINARY         = "ordinary",
  PREFERENCE       = "preference",
  REDEEMABLE       = "redeemable",
  OTHER            = "other"
}

enum PersonType {
  NATURAL_PERSON   = "natural_person",
  CORPORATION      = "corporation"
}

enum OutputFormat {
  PDF              = "pdf",
  EXCEL            = "excel",
  CSV              = "csv",
  JSON             = "json"             // For API consumers
}

// ─────────────────────────────────────────────
// Shared Base Types
// ─────────────────────────────────────────────

type DateRange = {
  from: ISODateString;
  to: ISODateString;
}

type Money = {
  amount: number;           // Always in SGD (or stated currency)
  currency: string;         // ISO 4217, default "SGD"
  sgd_equivalent?: number;  // If currency !== SGD
}

type Address = {
  line1: string;
  line2?: string;
  postal_code: string;
  country: string;          // ISO 3166-1 alpha-2, default "SG"
}

type PersonIdentity = {
  full_name: string;
  id_type: "nric" | "fin" | "passport" | "uen";
  id_number: string;        // Masked in display: show last 4 only
  nationality: string;
  date_of_birth?: ISODateString;
}

type ReportMetadata = {
  report_type: ReportType;
  report_title: string;
  generated_at: ISODateTimeString;
  generated_by: string;     // User name
  firm_name: string;
  filters_applied: Record<string, unknown>;
  total_records: number;
  page?: number;
  total_pages?: number;
}

type ComplianceFlag = {
  severity: "info" | "warning" | "critical";
  code: string;             // e.g., "AR_OVERDUE", "NO_SECRETARY", "EPC_LOST"
  message: string;
  affected_company_uen?: string;
  deadline?: ISODateString;
  days_overdue?: number;
}
```

---

## CSS Reports — 24 Types

### CSS-01: Company List Report

```typescript
type CSS01_Params = {
  company_ids?: string[];           // null = all companies in portfolio
  status_filter: "active" | "struck_off" | "winding_up" | "all";
  as_at_date: ISODateString;
  include_compliance_score: boolean;
  output_format: OutputFormat;
}

type CSS01_CompanyRow = {
  // Identity
  uen: string;
  name: string;
  type: CompanyType;
  incorporation_date: ISODateString;
  incorporation_country: string;

  // Address & Activity
  registered_address: Address;
  principal_activity: string;
  ssic_code: string;                // Singapore Standard Industrial Classification

  // Financial Year
  fye_date: ISODateString;          // Financial Year End date (MM-DD)
  fye_month: number;                // 1–12

  // Officers (current counts)
  director_count: number;
  secretary_name: string | null;
  auditor_firm: string | null;

  // Share Capital
  issued_share_capital: Money;
  paid_up_capital: Money;
  share_classes: string[];

  // Compliance Status
  ar_status: ComplianceStatus;
  ar_due_date: ISODateString;
  ar_last_filed: ISODateString | null;
  agm_status: ComplianceStatus;
  agm_due_date: ISODateString;
  agm_last_held: ISODateString | null;

  // Flags
  is_small_company: boolean;
  is_epc: boolean;
  is_dormant: boolean;
  is_audit_exempt: boolean;
  compliance_score?: number;        // 0–100 if include_compliance_score
  flags: ComplianceFlag[];
}

type CSS01_Dataset = {
  metadata: ReportMetadata;
  companies: CSS01_CompanyRow[];
  summary: {
    total_companies: number;
    by_type: Record<CompanyType, number>;
    by_ar_status: Record<ComplianceStatus, number>;
    by_agm_status: Record<ComplianceStatus, number>;
    companies_with_flags: number;
  };
}
```

---

### CSS-02: Director Report

```typescript
type CSS02_Params = {
  company_ids?: string[];
  include_ceased: boolean;          // Include directors who have ceased
  as_at_date: ISODateString;
  cross_company_view: boolean;      // Group by director (shows all directorships)
  output_format: OutputFormat;
}

type CSS02_DirectorRow = {
  // Personal
  identity: PersonIdentity;
  residential_address: Address;
  email?: string;

  // Appointment
  company_uen: string;
  company_name: string;
  designation: string;              // "Executive Director", "Non-Executive Director", etc.
  appointed_date: ISODateString;
  ceased_date: ISODateString | null;
  is_current: boolean;
  tenure_years: number;             // Computed: years in office

  // Holdings in this company
  shares_held: number | null;
  share_class: ShareClass | null;
  shareholding_pct: number | null;

  // Cross-company stats (populated if cross_company_view)
  total_sg_directorships?: number;  // Count of active SG directorships
  other_companies?: string[];       // Names of other companies

  // Flags
  is_nominee: boolean;
  rotation_due: boolean;            // If Articles require rotation at next AGM
  flags: ComplianceFlag[];
}

type CSS02_Dataset = {
  metadata: ReportMetadata;
  directors: CSS02_DirectorRow[];
  summary: {
    total_director_records: number;
    unique_directors: number;
    current_directors: number;
    ceased_directors: number;
    directors_with_flags: number;
    avg_tenure_years: number;
  };
}
```

---

### CSS-03: Shareholder Report

```typescript
type CSS03_Params = {
  company_ids?: string[];
  share_class_filter?: ShareClass[];
  as_at_date: ISODateString;
  minimum_shareholding_pct?: number;  // e.g., 5.0 to show only ≥5% holders
  include_historical: boolean;
  output_format: OutputFormat;
}

type CSS03_ShareholderRow = {
  // Identity
  name: string;
  id_type: "nric" | "fin" | "passport" | "uen";
  id_number_masked: string;         // Last 4 digits only
  type: PersonType;
  address?: Address;
  nationality?: string;

  // Company context
  company_uen: string;
  company_name: string;

  // Holdings
  share_class: ShareClass;
  shares_held: number;
  shareholding_pct: number;         // To 4 decimal places
  consideration_paid: Money | null;

  // Transaction history (if include_historical)
  acquisition_date: ISODateString;
  acquisition_method: "allotment" | "transfer" | "subscription" | string;
  disposal_date?: ISODateString;
  disposal_method?: string;

  // Thresholds
  above_5pct: boolean;
  above_25pct: boolean;             // Registrable Controller threshold
  above_50pct: boolean;
  above_75pct: boolean;

  // Flags
  is_registrable_controller: boolean;
  is_nominee?: boolean;
  flags: ComplianceFlag[];
}

type CSS03_CapTableEntry = {
  share_class: ShareClass;
  total_issued: number;
  total_shareholders: number;
  shareholders: CSS03_ShareholderRow[];
}

type CSS03_Dataset = {
  metadata: ReportMetadata;
  companies: {
    uen: string;
    name: string;
    total_issued_shares: number;
    total_paid_up_capital: Money;
    cap_table: CSS03_CapTableEntry[];
  }[];
  summary: {
    total_shareholder_records: number;
    unique_shareholders: number;
    corporate_shareholders: number;
    natural_person_shareholders: number;
    shareholders_above_25pct: number;
  };
}
```

---

### CSS-04: Secretary Report

```typescript
type CSS04_Params = {
  company_ids?: string[];
  include_ceased: boolean;
  as_at_date: ISODateString;
  output_format: OutputFormat;
}

type CSS04_SecretaryRow = {
  // Personal
  name: string;
  id_number_masked: string;
  qualification_type:
    | "icsa_member"
    | "sca_member"
    | "lawyer"
    | "3yr_experience"
    | "corporate_secretary_firm"
    | string;
  qualification_body?: string;

  // Appointment
  company_uen: string;
  company_name: string;
  firm_name?: string;               // If corporate secretary
  appointed_date: ISODateString;
  ceased_date: ISODateString | null;
  is_current: boolean;
  tenure_years: number;

  // Contact
  email?: string;
  phone?: string;

  // Flags
  qualification_verified: boolean;
  flags: ComplianceFlag[];          // e.g., "NO_SECRETARY" if company has none
}

type CSS04_Dataset = {
  metadata: ReportMetadata;
  secretaries: CSS04_SecretaryRow[];
  summary: {
    companies_with_secretary: number;
    companies_without_secretary: number;
    unique_secretaries: number;
    corporate_secretary_firms: number;
  };
}
```

---

### CSS-05: AGM Report

```typescript
type CSS05_Params = {
  company_ids?: string[];
  fye_month_filter?: number[];      // e.g., [3, 6, 9, 12] for quarterly FYEs
  look_ahead_days: number;          // Show upcoming AGMs within N days
  status_filter?: ComplianceStatus[];
  output_format: OutputFormat;
}

type CSS05_AGMRow = {
  company_uen: string;
  company_name: string;
  company_type: CompanyType;

  // Financial year
  fye_date: ISODateString;
  financial_year_label: string;     // e.g., "FY2025" or "FY ended 31 Dec 2025"

  // AGM history
  last_agm_date: ISODateString | null;
  last_agm_type: "agm" | "dispensation" | null;
  last_agm_resolution_method: "in_person" | "virtual" | "written_resolution" | null;

  // Upcoming AGM
  agm_due_date: ISODateString;
  days_until_due: number;           // Negative = overdue
  agm_status: ComplianceStatus;

  // Exemptions
  is_epc: boolean;                  // EPC: AGM not required
  is_exempt_private: boolean;
  dispensed_under_175a: boolean;    // S.175A dispensation for this year

  // Accounts readiness
  accounts_finalised: boolean;
  accounts_date: ISODateString | null;
  audit_required: boolean;
  audit_completed: boolean;

  // Actions needed
  next_action: string;              // Human-readable next step
  next_action_deadline: ISODateString | null;

  flags: ComplianceFlag[];
}

type CSS05_Dataset = {
  metadata: ReportMetadata;
  agm_records: CSS05_AGMRow[];
  summary: {
    total_companies: number;
    agm_compliant: number;
    agm_due_soon: number;
    agm_overdue: number;
    agm_not_required: number;
    dispensations_this_year: number;
  };
  upcoming_by_month: {
    month: string;                  // "2026-03"
    company_count: number;
    companies: string[];            // Company names
  }[];
}
```

---

### CSS-06: Annual Return Report

```typescript
type CSS06_Params = {
  company_ids?: string[];
  filing_year?: number;             // Financial year of AR
  status_filter?: ComplianceStatus[];
  look_ahead_days: number;
  output_format: OutputFormat;
}

type CSS06_ARRow = {
  company_uen: string;
  company_name: string;
  company_type: CompanyType;
  fye_date: ISODateString;

  // AR Details
  ar_period_label: string;          // "AR for FY ended 31 Dec 2025"
  ar_due_date: ISODateString;
  ar_filed_date: ISODateString | null;
  ar_status: ComplianceStatus;
  days_until_due: number;           // Negative = overdue
  days_overdue: number | null;

  // Filing scope
  is_epc: boolean;
  financial_statements_required: boolean;
  financial_statements_filed: boolean;
  is_small_company: boolean;
  audit_required: boolean;

  // Penalties (if overdue — for user reference only)
  estimated_penalty_sgd?: number;   // ACRA late filing penalty
  late_filing_days?: number;

  // ACRA reference
  acra_transaction_number?: string; // If already filed

  flags: ComplianceFlag[];
}

type CSS06_Dataset = {
  metadata: ReportMetadata;
  ar_records: CSS06_ARRow[];
  summary: {
    total_companies: number;
    filed: number;
    due_soon: number;
    overdue: number;
    total_estimated_penalties: Money;
  };
  by_month: {
    month: string;
    due_count: number;
    filed_count: number;
    overdue_count: number;
  }[];
}
```

---

### CSS-07: FYE Report

```typescript
type CSS07_Params = {
  company_ids?: string[];
  fye_month_filter?: number[];
  look_ahead_days: number;
  output_format: OutputFormat;
}

type CSS07_FYERow = {
  company_uen: string;
  company_name: string;
  fye_date: ISODateString;
  fye_month: number;
  financial_year_label: string;
  financial_year_start: ISODateString;

  // Deadline chain (computed from FYE)
  accounts_due_date: ISODateString;       // Typically 4 months after FYE
  audit_completion_target: ISODateString; // Typically 4.5 months after FYE
  agm_due_date: ISODateString;            // 6 months after FYE (private)
  ar_due_date: ISODateString;             // 7 months after FYE (private)
  corporate_tax_due_date: ISODateString;  // 11 months after FYE (ECI)
  estimated_tax_return_due: ISODateString; // Form C/C-S: 30 Nov each year

  // Status of each milestone
  accounts_status: ComplianceStatus;
  audit_status: ComplianceStatus;
  agm_status: ComplianceStatus;
  ar_status: ComplianceStatus;

  // Days until next milestone (nearest upcoming deadline)
  next_deadline_label: string;
  next_deadline_date: ISODateString;
  days_until_next_deadline: number;

  flags: ComplianceFlag[];
}

type CSS07_Dataset = {
  metadata: ReportMetadata;
  fye_records: CSS07_FYERow[];
  summary: {
    total_companies: number;
    by_fye_month: Record<number, number>;   // month number → company count
  };
  calendar_view: {
    month: string;                           // "2026-03"
    deadlines: {
      company_name: string;
      company_uen: string;
      deadline_type: string;
      deadline_date: ISODateString;
      status: ComplianceStatus;
    }[];
  }[];
}
```

---

### CSS-08: Share Capital Report

```typescript
type CSS08_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  include_transaction_history: boolean;
  output_format: OutputFormat;
}

type CSS08_ShareClassRow = {
  share_class: ShareClass;
  class_label: string;              // e.g., "Ordinary Shares", "Series A Preference"
  authorised_shares: number | null;
  issued_shares: number;
  paid_up_shares: number;
  partly_paid_shares: number;
  issue_price: Money;
  total_consideration: Money;
  carrying_value: Money;
  shareholder_count: number;
}

type CSS08_Transaction = {
  date: ISODateString;
  type: "allotment" | "transfer" | "buyback" | "cancellation" | "conversion" | string;
  shares: number;
  share_class: ShareClass;
  consideration: Money | null;
  description: string;
  resolution_reference: string | null;
}

type CSS08_CompanyCapital = {
  company_uen: string;
  company_name: string;
  as_at_date: ISODateString;

  // Aggregate
  total_authorised_shares: number | null;
  total_issued_shares: number;
  total_paid_up_capital: Money;
  total_shareholders: number;

  // By class
  share_classes: CSS08_ShareClassRow[];

  // Change from prior period (if prior data available)
  prior_period_label: string | null;
  issued_shares_change: number | null;
  paid_up_capital_change: Money | null;

  // History
  transaction_history?: CSS08_Transaction[];

  flags: ComplianceFlag[];
}

type CSS08_Dataset = {
  metadata: ReportMetadata;
  companies: CSS08_CompanyCapital[];
  portfolio_summary: {
    total_companies: number;
    total_paid_up_capital_sgd: number;
    total_shareholders_across_portfolio: number;
    companies_with_preference_shares: number;
    companies_with_partly_paid_shares: number;
  };
}
```

---

### CSS-09: Registered Address Report

```typescript
type CSS09_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  include_history: boolean;
  output_format: OutputFormat;
}

type CSS09_AddressRecord = {
  company_uen: string;
  company_name: string;
  current_address: Address;
  effective_from: ISODateString;
  is_current: boolean;

  // History (if include_history)
  address_history?: {
    address: Address;
    effective_from: ISODateString;
    effective_to: ISODateString;
    change_reason?: string;
  }[];

  // Compliance
  is_po_box: boolean;               // Flag: PO Box not permitted as registered address
  is_accessible_business_hours: boolean | null;

  flags: ComplianceFlag[];
}

type CSS09_Dataset = {
  metadata: ReportMetadata;
  address_records: CSS09_AddressRecord[];
  summary: {
    total_companies: number;
    unique_addresses: number;
    companies_sharing_address: {
      address: string;
      company_count: number;
      companies: string[];
    }[];
    po_box_flags: number;
  };
}
```

---

### CSS-10: Auditor Report

```typescript
type CSS10_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  include_history: boolean;
  flag_rotation_required: boolean;  // Flag if partner has served >5 years
  output_format: OutputFormat;
}

type CSS10_AuditorRow = {
  company_uen: string;
  company_name: string;
  is_audit_required: boolean;
  audit_exemption_reason?: "small_company" | "epc" | "dormant" | "exempt_private" | null;

  // Current auditor
  firm_name: string | null;
  pab_number: string | null;        // Public Accountants Board registration
  engagement_partner: string | null;
  partner_appointed_date: ISODateString | null;
  partner_tenure_years: number | null;
  firm_appointed_date: ISODateString | null;
  audit_fee_sgd: number | null;

  // Rotation
  partner_rotation_due: boolean;    // True if ≥5 years
  partner_rotation_due_date: ISODateString | null;

  // History (if include_history)
  auditor_history?: {
    firm_name: string;
    partner: string;
    period_from: ISODateString;
    period_to: ISODateString;
    change_reason?: string;
  }[];

  flags: ComplianceFlag[];
}

type CSS10_Dataset = {
  metadata: ReportMetadata;
  auditor_records: CSS10_AuditorRow[];
  summary: {
    total_companies: number;
    audit_required: number;
    audit_exempt: number;
    rotation_due: number;
    by_audit_firm: {
      firm_name: string;
      client_count: number;
    }[];
  };
}
```

---

### CSS-11: Charges Report

```typescript
type CSS11_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  status_filter: "outstanding" | "discharged" | "all";
  output_format: OutputFormat;
}

type CSS11_ChargeRow = {
  company_uen: string;
  company_name: string;
  charge_id: string;
  acra_registration_number: string | null;

  // Charge details
  chargee_name: string;
  chargee_type: "bank" | "individual" | "company" | string;
  charge_type: string;              // "Fixed", "Floating", "Fixed and Floating"
  charged_assets: string;           // Description of secured assets
  charge_amount: Money;
  charge_currency: string;
  date_created: ISODateString;
  date_registered: ISODateString;

  // Late registration check
  days_to_register: number;         // Should be ≤ 30 days
  is_late_registration: boolean;

  // Status
  status: "outstanding" | "discharged";
  discharge_date: ISODateString | null;
  discharge_reference: string | null;

  flags: ComplianceFlag[];
}

type CSS11_Dataset = {
  metadata: ReportMetadata;
  charge_records: CSS11_ChargeRow[];
  summary: {
    total_charges: number;
    outstanding_charges: number;
    discharged_charges: number;
    total_outstanding_value: Money;
    late_registrations: number;
    companies_with_charges: number;
  };
}
```

---

### CSS-12: Controllers Report

```typescript
type CSS12_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  minimum_threshold_pct: number;    // Default 25
  output_format: OutputFormat;
}

type CSS12_ControllerRow = {
  company_uen: string;
  company_name: string;

  // Controller identity
  controller_name: string;
  controller_type: PersonType;
  id_number_masked: string;
  nationality: string;
  address: Address;
  country_of_incorporation?: string; // For corporate controllers

  // Nature of control
  control_type: "ownership" | "voting" | "right_to_appoint" | "significant_influence" | string;
  shareholding_pct: number | null;
  voting_rights_pct: number | null;

  // Registration
  date_registered: ISODateString;
  date_ceased: ISODateString | null;
  is_current: boolean;

  // Ultimate beneficial owner (for corporate controllers)
  ubo_name?: string;
  ubo_nationality?: string;
  ubo_shareholding_pct?: number;

  // Notification
  controller_notified: boolean;
  notification_date: ISODateString | null;
  controller_confirmed: boolean;

  flags: ComplianceFlag[];
}

type CSS12_Dataset = {
  metadata: ReportMetadata;
  controller_records: CSS12_ControllerRow[];
  summary: {
    total_companies: number;
    companies_with_controllers: number;
    total_controller_records: number;
    unconfirmed_controllers: number;
    corporate_controllers: number;
  };
}
```

---

### CSS-13: Nominee Directors Report

```typescript
type CSS13_Params = {
  company_ids?: string[];
  as_at_date: ISODateString;
  include_ceased: boolean;
  output_format: OutputFormat;
}

type CSS13_NomineeRow = {
  company_uen: string;
  company_name: string;
  nominee_director_name: string;
  nominee_nric_masked: string;
  appointed_date: ISODateString;
  ceased_date: ISODateString | null;
  is_current: boolean;

  // Nominator
  nominator_name: string;
  nominator_type: PersonType;
  nominator_id_masked: string;
  nomination_relationship: string;
  nomination_arrangement_description: string;

  // Declaration
  declaration_signed: boolean;
  declaration_date: ISODateString | null;
  days_to_declare: number | null;   // Should be ≤ 30 days from appointment
  is_late_declaration: boolean;

  flags: ComplianceFlag[];
}

type CSS13_Dataset = {
  metadata: ReportMetadata;
  nominee_records: CSS13_NomineeRow[];
  summary: {
    total_nominee_arrangements: number;
    current_arrangements: number;
    late_declarations: number;
    unsigned_declarations: number;
  };
}
```

---

### CSS-14 to CSS-24: Remaining CSS Report Types

```typescript
// CSS-14: Seals Report
type CSS14_SealRow = {
  company_uen: string;
  company_name: string;
  has_common_seal: boolean;
  seal_abolished: boolean;
  seal_abolished_date?: ISODateString;
  usage_records: {
    usage_date: ISODateString;
    document_sealed: string;
    authorising_directors: string[];  // Minimum 2 required
    purpose: string;
  }[];
  total_usages: number;
  last_usage_date: ISODateString | null;
  flags: ComplianceFlag[];
}

// CSS-15: Allotments Report
type CSS15_AllotmentRow = {
  company_uen: string;
  company_name: string;
  allotment_date: ISODateString;
  allottee_name: string;
  allottee_id_masked: string;
  shares_allotted: number;
  share_class: ShareClass;
  issue_price: Money;
  total_consideration: Money;
  return_of_allotment_filed: boolean;
  filing_date: ISODateString | null;
  days_to_file: number | null;
  is_late_filing: boolean;
  resolution_reference: string;
  flags: ComplianceFlag[];
}

// CSS-16: Transfers Report
type CSS16_TransferRow = {
  company_uen: string;
  company_name: string;
  transfer_date: ISODateString;
  transferor_name: string;
  transferee_name: string;
  shares_transferred: number;
  share_class: ShareClass;
  consideration: Money;
  stamp_duty_paid: Money | null;
  stamp_duty_due_date: ISODateString;
  instrument_stamped: boolean;
  board_approval_date: ISODateString;
  register_updated: boolean;
  certificate_issued: boolean;
  flags: ComplianceFlag[];
}

// CSS-17: Dividends Report
type CSS17_DividendRow = {
  company_uen: string;
  company_name: string;
  declaration_date: ISODateString;
  dividend_type: "interim" | "final" | "special";
  share_class: ShareClass;
  amount_per_share: Money;
  total_dividend: Money;
  record_date: ISODateString;
  payment_date: ISODateString;
  paid: boolean;
  payment_date_actual: ISODateString | null;
  resolution_type: "board" | "members";
  distributable_reserves_at_declaration: Money | null;
  flags: ComplianceFlag[];
}

// CSS-18: Resolutions Index
type CSS18_ResolutionRow = {
  company_uen: string;
  company_name: string;
  resolution_date: ISODateString;
  resolution_type: "ordinary" | "special" | "written";
  category: string;                 // e.g., "Director Appointment", "Share Allotment"
  description: string;
  passed: boolean;
  votes_for_pct: number | null;
  passed_by: "board" | "members";
  resolution_reference: string;
  document_stored: boolean;
  document_url: string | null;
  flags: ComplianceFlag[];
}

// CSS-19: Minutes Index
type CSS19_MinutesRow = {
  company_uen: string;
  company_name: string;
  meeting_date: ISODateString;
  meeting_type: "board" | "agm" | "egm" | "class_meeting";
  meeting_number: number;
  chairperson: string;
  attendee_count: number;
  quorum_achieved: boolean;
  resolutions_passed: number;
  minutes_signed: boolean;
  minutes_signed_date: ISODateString | null;
  document_stored: boolean;
  document_url: string | null;
  flags: ComplianceFlag[];
}

// CSS-20: Filing Calendar
type CSS20_FilingCalendarRow = {
  company_uen: string;
  company_name: string;
  deadline_type: string;
  deadline_date: ISODateString;
  days_until: number;
  status: ComplianceStatus;
  assigned_to: string | null;
  notes: string | null;
  flags: ComplianceFlag[];
}

// CSS-21: Compliance Score Report
type CSS21_ComplianceRow = {
  company_uen: string;
  company_name: string;
  overall_score: number;            // 0–100
  score_components: {
    category: string;
    weight_pct: number;
    score: number;
    max_score: number;
    weighted_score: number;
    issues: string[];
  }[];
  grade: "A" | "B" | "C" | "D" | "F";
  critical_flags: ComplianceFlag[];
  warning_flags: ComplianceFlag[];
  last_assessed: ISODateString;
}

// CSS-22: Beneficial Owner Report
// (Combines Controllers + Nominees into UBO view)
type CSS22_UBORow = {
  company_uen: string;
  company_name: string;
  ubo_name: string;
  ubo_nationality: string;
  ubo_id_masked: string;
  ubo_type: PersonType;
  control_chain: string;            // e.g., "Direct → via HoldCo SG → Company"
  effective_ownership_pct: number;
  source: "direct_shareholder" | "registrable_controller" | "nominee_arrangement";
  disclosure_status: "disclosed" | "pending" | "refused";
  flags: ComplianceFlag[];
}

// CSS-23: XBRL Summary Report
type CSS23_XBRLRow = {
  company_uen: string;
  company_name: string;
  fye_date: ISODateString;
  xbrl_required: boolean;
  xbrl_filed: boolean;
  filing_date: ISODateString | null;
  xbrl_version: string | null;      // e.g., "ACRA XBRL 2013"
  financial_highlights: {
    revenue: Money;
    net_profit: Money;
    total_assets: Money;
    total_equity: Money;
  } | null;
  flags: ComplianceFlag[];
}

// CSS-24: Portfolio Dashboard (Aggregate)
type CSS24_PortfolioDashboard = {
  metadata: ReportMetadata;
  as_at_date: ISODateString;
  total_companies: number;
  portfolio_health: {
    compliant: number;
    due_soon: number;
    overdue: number;
    critical_flags: number;
  };
  upcoming_7_days: CSS20_FilingCalendarRow[];
  upcoming_30_days: CSS20_FilingCalendarRow[];
  overdue_items: CSS20_FilingCalendarRow[];
  top_compliance_issues: { issue_code: string; count: number; description: string }[];
  compliance_score_distribution: Record<string, number>;  // grade → count
}
```

---

## CRM Reports — 12 Types

```typescript
// ─────────────────────────────────────────────
// CRM Shared Types
// ─────────────────────────────────────────────

type CRM_Lead = {
  id: string;
  name: string;
  source: string;
  status: "new" | "qualified" | "proposal" | "negotiation" | "closed_won" | "closed_lost";
  assigned_to: string;
  created_at: ISODateTimeString;
  converted_at: ISODateTimeString | null;
  estimated_value: Money;
}

type CRM_Client = {
  id: string;
  company_name: string;
  account_manager: string;
  since_date: ISODateString;
  tier: "standard" | "premium" | "enterprise";
  linked_company_uens: string[];
  annual_fee_sgd: number;
  renewal_date: ISODateString | null;
}

type CRM_Invoice = {
  id: string;
  client_id: string;
  client_name: string;
  issue_date: ISODateString;
  due_date: ISODateString;
  amount: Money;
  status: "draft" | "sent" | "paid" | "overdue" | "written_off";
  paid_date: ISODateString | null;
  days_outstanding: number | null;
  aging_bucket: "current" | "1_30" | "31_60" | "61_90" | "over_90";
}

type CRM_Activity = {
  id: string;
  type: "call" | "email" | "meeting" | "task" | "note";
  subject: string;
  client_id: string | null;
  lead_id: string | null;
  assigned_to: string;
  due_date: ISODateString;
  completed: boolean;
  completed_at: ISODateTimeString | null;
}

type CRM_Timesheet = {
  id: string;
  staff_name: string;
  client_id: string;
  task_description: string;
  date: ISODateString;
  hours: number;
  billable: boolean;
  billing_rate_per_hour: number;
  billed: boolean;
  invoice_id: string | null;
}

// ─────────────────────────────────────────────
// CRM-01: Lead Pipeline Report
// ─────────────────────────────────────────────

type CRM01_Params = {
  date_range: DateRange;
  assigned_to_filter?: string[];
  status_filter?: CRM_Lead["status"][];
  output_format: OutputFormat;
}

type CRM01_Dataset = {
  metadata: ReportMetadata;
  leads: CRM_Lead[];
  pipeline_summary: {
    total_leads: number;
    total_pipeline_value: Money;
    by_stage: Record<CRM_Lead["status"], { count: number; value: Money }>;
    conversion_rate_pct: number;
    avg_days_to_convert: number | null;
    win_rate_pct: number;
  };
  by_source: { source: string; count: number; value: Money }[];
  by_assignee: { name: string; leads: number; won: number; value: Money }[];
}

// ─────────────────────────────────────────────
// CRM-02: Sales Conversion Report
// ─────────────────────────────────────────────

type CRM02_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  new_leads: number;
  qualified_leads: number;
  proposals_sent: number;
  deals_won: number;
  deals_lost: number;
  conversion_funnel: {
    stage: string;
    count: number;
    conversion_from_prior_pct: number;
  }[];
  revenue_won: Money;
  avg_deal_value: Money;
  avg_sales_cycle_days: number;
  lost_reasons: { reason: string; count: number }[];
}

// ─────────────────────────────────────────────
// CRM-03: Invoice Ageing Report
// ─────────────────────────────────────────────

type CRM03_Params = {
  as_at_date: ISODateString;
  client_filter?: string[];
  status_filter?: CRM_Invoice["status"][];
  output_format: OutputFormat;
}

type CRM03_Dataset = {
  metadata: ReportMetadata;
  invoices: CRM_Invoice[];
  ageing_summary: {
    current: Money;
    days_1_30: Money;
    days_31_60: Money;
    days_61_90: Money;
    over_90: Money;
    total_outstanding: Money;
    total_written_off: Money;
  };
  by_client: {
    client_name: string;
    total_outstanding: Money;
    oldest_invoice_days: number;
    invoices: CRM_Invoice[];
  }[];
  collection_risk: {
    low_risk: Money;    // Current + 1-30 days
    medium_risk: Money; // 31-60 days
    high_risk: Money;   // 61+ days
  };
}

// ─────────────────────────────────────────────
// CRM-04: Revenue by Client Report
// ─────────────────────────────────────────────

type CRM04_Params = {
  date_range: DateRange;
  group_by: "client" | "service_type" | "month" | "quarter";
  output_format: OutputFormat;
}

type CRM04_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  total_revenue: Money;
  total_invoiced: Money;
  total_collected: Money;
  collection_rate_pct: number;
  by_client: {
    client_id: string;
    client_name: string;
    revenue: Money;
    invoiced: Money;
    collected: Money;
    outstanding: Money;
    revenue_pct_of_total: number;
    yoy_change_pct: number | null;
  }[];
  monthly_trend: { month: string; revenue: Money; collected: Money }[];
  top_10_clients: string[];         // Client names
}

// ─────────────────────────────────────────────
// CRM-05: Project Status Report
// ─────────────────────────────────────────────

type CRM05_ProjectRow = {
  project_id: string;
  project_name: string;
  client_name: string;
  project_type: string;             // e.g., "Corp Sec Retainer", "IPO Advisory", "M&A"
  status: "not_started" | "in_progress" | "on_hold" | "completed" | "cancelled";
  start_date: ISODateString;
  expected_end_date: ISODateString;
  actual_end_date: ISODateString | null;
  project_manager: string;
  budget: Money;
  billed_to_date: Money;
  estimated_completion_pct: number;
  milestones: {
    name: string;
    due_date: ISODateString;
    completed: boolean;
    completed_date: ISODateString | null;
  }[];
  is_overdue: boolean;
  days_overdue: number | null;
}

type CRM05_Dataset = {
  metadata: ReportMetadata;
  projects: CRM05_ProjectRow[];
  summary: {
    total_projects: number;
    by_status: Record<string, number>;
    total_budget: Money;
    total_billed: Money;
    overdue_projects: number;
  };
}

// ─────────────────────────────────────────────
// CRM-06: Activity Log Report
// ─────────────────────────────────────────────

type CRM06_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  activities: CRM_Activity[];
  summary: {
    total_activities: number;
    completed: number;
    pending: number;
    overdue: number;
    by_type: Record<CRM_Activity["type"], number>;
    by_assignee: { name: string; total: number; completed: number; completion_rate_pct: number }[];
    completion_rate_pct: number;
  };
}

// ─────────────────────────────────────────────
// CRM-07: Timesheet Summary Report
// ─────────────────────────────────────────────

type CRM07_Params = {
  date_range: DateRange;
  staff_filter?: string[];
  client_filter?: string[];
  billable_only: boolean;
  output_format: OutputFormat;
}

type CRM07_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  timesheets: CRM_Timesheet[];
  summary: {
    total_hours: number;
    billable_hours: number;
    non_billable_hours: number;
    billable_pct: number;
    total_billing_value: Money;
    billed_value: Money;
    unbilled_value: Money;
  };
  by_staff: {
    name: string;
    total_hours: number;
    billable_hours: number;
    billable_pct: number;
    billing_value: Money;
  }[];
  by_client: {
    client_name: string;
    hours: number;
    billing_value: Money;
    billed: boolean;
  }[];
  weekly_trend: { week: string; hours: number; billable_hours: number }[];
}

// ─────────────────────────────────────────────
// CRM-08: Engagement Profitability Report
// ─────────────────────────────────────────────

type CRM08_EngagementRow = {
  client_id: string;
  client_name: string;
  engagement_type: string;
  date_range: DateRange;
  fee_charged: Money;
  direct_costs: Money;           // Staff time at cost rate
  indirect_costs: Money;         // Overhead allocation
  gross_profit: Money;
  gross_margin_pct: number;
  net_profit: Money;
  net_margin_pct: number;
  hours_spent: number;
  effective_hourly_rate: Money;
  target_hourly_rate: Money;
  rate_variance_pct: number;
}

type CRM08_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  engagements: CRM08_EngagementRow[];
  portfolio_summary: {
    total_revenue: Money;
    total_direct_costs: Money;
    gross_profit: Money;
    gross_margin_pct: number;
    most_profitable_client: string;
    least_profitable_client: string;
  };
}

// ─────────────────────────────────────────────
// CRM-09: Client Renewal Calendar
// ─────────────────────────────────────────────

type CRM09_RenewalRow = {
  client_id: string;
  client_name: string;
  account_manager: string;
  contract_start: ISODateString;
  renewal_date: ISODateString;
  days_until_renewal: number;
  annual_fee: Money;
  auto_renew: boolean;
  renewal_status: "confirmed" | "in_discussion" | "at_risk" | "churned" | "pending";
  last_contact_date: ISODateString | null;
  renewal_probability_pct: number | null;
  notes: string | null;
}

type CRM09_Dataset = {
  metadata: ReportMetadata;
  renewals: CRM09_RenewalRow[];
  summary: {
    total_renewals_due: number;
    total_arr_at_risk: Money;
    confirmed: number;
    at_risk: number;
    renewal_rate_last_12m_pct: number;
  };
  by_month: { month: string; count: number; arr_value: Money }[];
}

// ─────────────────────────────────────────────
// CRM-10: Staff Utilisation Report
// ─────────────────────────────────────────────

type CRM10_StaffRow = {
  staff_name: string;
  role: string;
  date_range: DateRange;
  available_hours: number;
  billable_hours: number;
  non_billable_hours: number;
  leave_hours: number;
  utilisation_rate_pct: number;    // billable / available
  target_utilisation_pct: number;
  variance_pct: number;
  billing_value: Money;
  cost_rate_per_hour: Money;
  billing_rate_per_hour: Money;
  gross_contribution: Money;
}

type CRM10_Dataset = {
  metadata: ReportMetadata;
  date_range: DateRange;
  staff_records: CRM10_StaffRow[];
  summary: {
    total_staff: number;
    avg_utilisation_pct: number;
    total_billable_hours: number;
    total_billing_value: Money;
    under_utilised_staff: number;  // Below target
    over_utilised_staff: number;   // Above target (burnout risk)
  };
}

// ─────────────────────────────────────────────
// CRM-11: Outstanding Payments Report
// ─────────────────────────────────────────────

type CRM11_Dataset = {
  metadata: ReportMetadata;
  as_at_date: ISODateString;
  outstanding_invoices: CRM_Invoice[];
  total_outstanding: Money;
  summary_by_client: {
    client_name: string;
    outstanding: Money;
    oldest_invoice_date: ISODateString;
    contact_email: string | null;
  }[];
  recommended_actions: {
    client_name: string;
    action: "send_reminder" | "call_client" | "escalate" | "engage_collection";
    reason: string;
    days_overdue: number;
  }[];
}

// ─────────────────────────────────────────────
// CRM-12: Annual Revenue Summary
// ─────────────────────────────────────────────

type CRM12_Dataset = {
  metadata: ReportMetadata;
  year: number;
  total_revenue: Money;
  recurring_revenue: Money;
  one_time_revenue: Money;
  new_client_revenue: Money;
  existing_client_revenue: Money;
  churned_revenue: Money;
  net_revenue_retention_pct: number;
  monthly_breakdown: {
    month: string;
    revenue: Money;
    new_clients: number;
    churned_clients: number;
    invoices_issued: number;
    invoices_paid: number;
  }[];
  yoy_comparison: {
    current_year: Money;
    prior_year: Money;
    change_pct: number;
    change_abs: Money;
  } | null;
  top_10_clients_by_revenue: { rank: number; client_name: string; revenue: Money; pct_of_total: number }[];
}
```

---

## Report Generation API Contract

```typescript
// ─────────────────────────────────────────────
// Report Request (sent from CorpFile frontend)
// ─────────────────────────────────────────────

type ReportRequest = {
  report_type: ReportType;         // CSS-01 through CSS-24, CRM-01 through CRM-12
  params: Record<string, unknown>; // Matched to the specific Params type above
  firm_id: string;
  requested_by_user_id: string;
  output_format: OutputFormat;
  delivery: "inline" | "download" | "email";
  email_recipients?: string[];
}

// ─────────────────────────────────────────────
// Report Response
// ─────────────────────────────────────────────

type ReportResponse = {
  request_id: string;
  status: "completed" | "generating" | "failed";
  report_type: ReportType;
  metadata: ReportMetadata;
  dataset: unknown;               // Typed per report — use discriminated union in implementation
  download_url?: string;          // Pre-signed S3 URL for PDF/Excel download
  generated_at: ISODateTimeString;
  expires_at: ISODateTimeString;  // Download link expiry
  errors?: { code: string; message: string }[];
}

// ─────────────────────────────────────────────
// Compliance Flag Codes Reference
// ─────────────────────────────────────────────

const COMPLIANCE_FLAGS = {
  // Annual Return
  "AR_OVERDUE":              "Annual Return filing is overdue",
  "AR_DUE_SOON":             "Annual Return due within 30 days",
  "AR_NOT_FILED":            "Annual Return has never been filed",

  // AGM
  "AGM_OVERDUE":             "AGM is overdue",
  "AGM_DUE_SOON":            "AGM due within 30 days",
  "AGM_ACCOUNTS_NOT_READY":  "Audited accounts not ready for AGM",

  // Officers
  "NO_SECRETARY":            "Company has no current secretary",
  "NO_DIRECTOR":             "Company has no current director",
  "BOARD_BELOW_MIN":         "Board below minimum director requirement",
  "DIRECTOR_DISQUALIFIED":   "Director may be disqualified",
  "SECRETARY_UNQUALIFIED":   "Secretary qualification not verified",

  // EPC / Small Company
  "EPC_CORPORATE_SH":        "Corporate shareholder detected — EPC status lost",
  "EPC_OVER_20_SH":          "More than 20 shareholders — EPC status lost",
  "SMALL_CO_THRESHOLD":      "Company approaching small company threshold",

  // Shares
  "ALLOTMENT_LATE_FILING":   "Return of Allotment filed late (>14 days)",
  "TRANSFER_UNSTAMPED":      "Share transfer instrument not stamped",
  "CAPITAL_BELOW_AUTH":      "Issued capital at authorised capital ceiling",
  "PRE_EMPTION_NOT_OFFERED": "Pre-emption rights may not have been offered",

  // Charges
  "CHARGE_LATE_REGISTRATION":"Charge registered >30 days after creation",
  "CHARGE_OUTSTANDING":      "Outstanding registered charge exists",

  // Controllers
  "CONTROLLER_UNCONFIRMED":  "Registrable controller has not confirmed details",
  "CONTROLLER_NOT_NOTIFIED": "Suspected controller has not been notified",

  // Nominees
  "NOMINEE_LATE_DECLARATION":"Nominee director declaration filed late (>30 days)",
  "NOMINEE_UNSIGNED":        "Nominee director declaration not signed",

  // Auditor
  "AUDIT_PARTNER_ROTATION":  "Engagement partner has served ≥5 consecutive years",
  "AUDITOR_PAB_INVALID":     "Auditor PAB registration not verified",
  "AUDIT_NOT_COMPLETED":     "Audit not completed before AGM deadline",

  // Solvency
  "GOING_CONCERN_DOUBT":     "Going concern doubt disclosed in accounts",
  "INSOLVENT_DIVIDEND":      "Dividend declared without sufficient distributable reserves",
} as const;
```

---

*End of Reports Data Schema Specification*
*All three deliverables complete.*
