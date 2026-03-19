# Change Types — Document Templates & Board Resolution Mapping

This reference defines all available corporate change types, their required documents, the Board Resolution wording for each, and the merge logic for combining multiple changes into a single resolution.

---

## Master Change Type List

These are the 15 change types available for company transfer-in and ongoing corporate changes:

| ID | Change Type | Chinese | Needs Board Resolution? | Supplementary Docs |
|----|------------|---------|------------------------|-------------------|
| `change_registered_office` | Change Registered Office | 变更注册地址 | YES | Notice of Registered Office |
| `change_secretary` | Change Secretary | 变更公司秘书 | YES | Secretary Consent + Old Secretary Resignation |
| `change_director` | Change Director | 变更董事 | YES | Form 45 + Nominee Agreement (if applicable) |
| `change_company_name` | Change Company Name | 变更公司名称 | YES | Special Resolution of Shareholders |
| `change_principal_activities` | Change Principal Activities | 变更主营业务 | YES | — |
| `change_registered_controller` | Change Registered Controller | 变更实控人 | YES | Registrable Controller Notice (S.386AG) |
| `change_accounting_period` | Change Accounting Period | 变更会计期间 | YES | — |
| `change_currency` | Change Currency | 变更货币 | YES | — |
| `increase_share_capital` | Increase Share Capital | 增加股本 | YES | Return of Allotment |
| `reduce_share_capital` | Reduce Share Capital | 减少股本 | YES | Special Resolution + Solvency Statement |
| `transfer_share` | Transfer Share | 股份转让 | YES | Share Transfer Form + Stamp Duty |
| `interim_dividend` | Interim Dividend | 中期分红 | YES | Dividend Voucher |
| `update_constitution` | Update Constitution | 更新章程 | YES | Special Resolution |
| `update_paid_up_capital` | Update Paid-up Capital | 更新实缴资本 | YES | — |
| `particulars_update` | Particulars Update | 个人信息更新 | NO | Notification letter only |

---

## Board Resolution Merge Logic

### The Merge Rule

When multiple changes are selected, **all Board Resolution items are merged into a single document**:

```
{company.name}
Company Registration No. {company.uen}
Incorporated in the Republic of Singapore

DIRECTORS' RESOLUTIONS IN WRITING
PURSUANT TO THE COMPANY'S CONSTITUTION

We, the undersigned, being all the Directors of the Company, 
hereby resolve as follows:

[RESOLUTION 1: Change of Registered Office]
...

[RESOLUTION 2: Appointment of New Secretary]  
...

[RESOLUTION 3: Appointment of New Director]
...

[Continue for each selected change...]

DIRECTORS:
{director_1_name}          {director_2_name}
_______________           _______________
Date: _______________
```

### Merge Exceptions

Some changes require a **Special Resolution** (passed by shareholders, not directors). These go into a **separate** document:
- `change_company_name` → Special Resolution of Shareholders
- `reduce_share_capital` → Special Resolution of Shareholders
- `update_constitution` → Special Resolution of Shareholders

If the user selects both Board Resolution items and Special Resolution items, generate:
1. `01_Board_Resolution_Combined.docx` (all director-level changes)
2. `01b_Special_Resolution_Combined.docx` (all shareholder-level changes)

---

## Change Type Details

### 1. Change Registered Office (变更注册地址)

**Typical transfer-in scenario**: Change to Yu Young's address.

**Board Resolution wording**:
```
CHANGE OF REGISTERED OFFICE

RESOLVED THAT the registered office of the Company be changed from:
{old_address}
to:
{new_address}
with effect from {effective_date}.

RESOLVED THAT the Secretary be authorised to notify the Registrar of 
Companies of the said change.
```

**Default new_address**: `51 Goldhill Plaza #20-07 Singapore 308900`

**Supplementary document**: Notice of Change of Registered Office
```
COMPANIES ACT (CAP. 50)
NOTICE OF CHANGE OF SITUATION OF REGISTERED OFFICE

Company Name: {company.name}
UEN: {company.uen}

The registered office of the above company has been changed from:
Old address: {old_address}
New address: {new_address}
Date of change: {effective_date}

Signed by: _______________
(Director/Secretary)
Date: _______________
```

**Fields needed**: `company.name`, `company.uen`, `old_address` (from Bizfile), `new_address`, `effective_date`

---

### 2. Change Secretary (变更公司秘书)

**Typical transfer-in scenario**: Resign old secretary, appoint YANG YUJIE.

**Board Resolution wording**:
```
RESIGNATION OF SECRETARY

NOTED THAT {old_secretary_name} has tendered their resignation as 
Secretary of the Company with effect from {effective_date}.

APPOINTMENT OF NEW SECRETARY

RESOLVED THAT YANG YUJIE (NRIC/ID: XXXXX) be and is hereby appointed 
as Secretary of the Company with effect from {effective_date}, in place 
of {old_secretary_name}.
```

**Supplementary documents**:

1. **Consent to Act as Secretary** (same as new-company template):
```
Name of company: {company.name}
Company No: {company.uen}

1. I, the undermentioned person, hereby consent to act as a secretary 
   of the abovenamed company with effect from {effective_date}.

2. I am a qualified person under section 171(1AA) of the Companies Act 
   by virtue of my being —
   *(iv) a member of the Chartered Secretaries Institute of Singapore.

Name: YANG YUJIE
Signature: _______________
Date: _______________
```

2. **Letter of Resignation — Old Secretary**:
```
To: The Board of Directors
{company.name}
{company.uen}

RESIGNATION AS COMPANY SECRETARY

I, {old_secretary_name}, hereby tender my resignation as Company Secretary 
of {company.name} with effect from {effective_date}.

Yours faithfully,
{old_secretary_name}
Date: {effective_date}
```

**Fields needed**: `company.name`, `company.uen`, `old_secretary_name` (from Bizfile), `effective_date`

---

### 3. Change Director (变更董事)

**Typical transfer-in scenario**: Add a local nominee director for SG residency requirement, and/or remove a departing director.

**Board Resolution wording — Appointment**:
```
APPOINTMENT OF DIRECTOR

RESOLVED THAT {new_director_name} (Passport/NRIC: {id_number}) be and 
is hereby appointed as a Director of the Company with effect from 
{effective_date}.
```

**Board Resolution wording — Resignation**:
```
RESIGNATION OF DIRECTOR

NOTED THAT {old_director_name} has tendered their resignation as Director 
of the Company with effect from {effective_date}.

RESOLVED THAT the resignation be accepted with effect from the said date.
```

**Supplementary documents**:

1. **Form 45 — Consent to Act as Director** (same template as new-company):
   - One per new director
   - Section 173C(a) of Companies Act
   - Full non-disqualification declaration
   - See the new-company registration skill's document map for the complete Form 45 template

2. **Nominee Director Agreement** (if the new director is a Yu Young nominee):
   - Agreement for Appointment of Non-Executive Local Resident Director
   - Bilingual (EN/CN)
   - Sets out scope and limitations of nominee director role

3. **Letter of Resignation — Departing Director** (if removing a director):
```
To: The Board of Directors
{company.name}
{company.uen}

RESIGNATION AS DIRECTOR

I, {old_director_name}, hereby tender my resignation as Director of 
{company.name} with effect from {effective_date}.

Yours faithfully,
{old_director_name}
Date: {effective_date}
```

**Fields needed**: `company.name`, `company.uen`, `new_director_name`, `new_director_id`, `new_director_address`, `new_director_nationality`, `new_director_dob`, `new_director_email`, `new_director_phone`, `old_director_name` (if removing), `effective_date`, `is_nominee`

---

### 4. Change Company Name (变更公司名称)

**Board Resolution wording**:
```
CHANGE OF COMPANY NAME

RESOLVED THAT the name of the Company be changed from "{old_name}" 
to "{new_name}", subject to the approval of the Registrar of Companies.

RESOLVED THAT the Secretary be authorised to file the necessary 
documents with the Registrar of Companies.
```

**Requires Special Resolution** (separate document):
```
{company.name}
Company Registration No. {company.uen}

SPECIAL RESOLUTION

At an Extraordinary General Meeting of the Company duly convened and 
held on {date}, the following Special Resolution was passed:

RESOLVED THAT the name of the Company be changed from "{old_name}" 
to "{new_name}".

Signed: _______________
(Chairman)
```

**Fields needed**: `company.name`, `company.uen`, `old_name`, `new_name`

---

### 5. Change Principal Activities (变更主营业务)

**Board Resolution wording**:
```
CHANGE OF PRINCIPAL ACTIVITIES

RESOLVED THAT the principal activities of the Company be changed from:
{old_activities} (SSIC Code: {old_ssic})
to:
{new_activities} (SSIC Code: {new_ssic})
with effect from {effective_date}.

RESOLVED THAT the Secretary be authorised to notify the Registrar 
of Companies of the said change.
```

**Fields needed**: `old_activities`, `old_ssic`, `new_activities`, `new_ssic`, `effective_date`

---

### 6. Change Registered Controller (变更实控人)

**Board Resolution wording**:
```
CHANGE OF REGISTRABLE CONTROLLER

NOTED THAT {old_controller_name} has ceased to be a registrable controller 
of the Company with effect from {effective_date}.

RESOLVED THAT {new_controller_name} be recorded as a registrable controller 
of the Company with effect from {effective_date}.

RESOLVED THAT the Secretary update the Register of Registrable Controllers 
accordingly.
```

**Supplementary document**: Registrable Controller Notice under S.386AG(2)(a) — same template as new-company registration skill's Document #5, with Part 1 (natural person) or Part 2 (company) logic.

**Fields needed**: `old_controller_name`, `new_controller_name`, `new_controller_details` (address, ID, nationality, etc.), `is_natural_person`, `effective_date`

---

### 7. Change Accounting Period (变更会计期间)

**Board Resolution wording**:
```
CHANGE OF FINANCIAL YEAR END

RESOLVED THAT the financial year end of the Company be changed from 
{old_fye} to {new_fye}, with the current financial period ending on {new_fye_date}.

RESOLVED THAT the Secretary be authorised to notify the Registrar 
of Companies of the said change.
```

**Fields needed**: `old_fye`, `new_fye`, `new_fye_date`

---

### 8. Change Currency (变更货币)

**Board Resolution wording**:
```
CHANGE OF SHARE CURRENCY

RESOLVED THAT the currency denomination of the Company's share capital 
be changed from {old_currency} to {new_currency} with effect from {effective_date}.
```

**Fields needed**: `old_currency`, `new_currency`, `effective_date`

---

### 9. Increase Share Capital (增加股本)

**Board Resolution wording**:
```
ALLOTMENT AND ISSUANCE OF NEW SHARES

RESOLVED THAT {number_of_new_shares} new ordinary shares of the Company 
at {price_per_share} {currency} per share be allotted and issued to:
| Name | No. of New Shares | Amount |
|------|-------------------|--------|
| {subscriber_name} | {shares} | {amount} |

RESOLVED THAT the Secretary file the Return of Allotment with the 
Registrar of Companies.
```

**Supplementary document**: Return of Allotment form

**Fields needed**: `number_of_new_shares`, `price_per_share`, `currency`, subscriber details

---

### 10. Reduce Share Capital (减少股本)

**Requires Special Resolution**.

**Board Resolution wording**:
```
REDUCTION OF SHARE CAPITAL

RESOLVED THAT the Company's share capital be reduced from {old_capital} 
to {new_capital} by cancellation of {shares_cancelled} shares.

RESOLVED THAT the directors confirm that the Company satisfies the 
solvency test as required under the Companies Act.
```

**Supplementary documents**: Special Resolution + Solvency Statement

---

### 11. Transfer Share (股份转让)

**Board Resolution wording**:
```
TRANSFER OF SHARES

RESOLVED THAT the transfer of {number_of_shares} ordinary shares from 
{transferor_name} to {transferee_name} at {price} {currency} per share 
be and is hereby approved.

RESOLVED THAT the share certificate(s) in respect of the transferred 
shares be cancelled and new share certificate(s) be issued to {transferee_name}.
```

**Supplementary documents**: Share Transfer Form + Stamp Duty computation

**Fields needed**: `transferor_name`, `transferee_name`, `number_of_shares`, `price`, `currency`

---

### 12. Interim Dividend (中期分红)

**Board Resolution wording**:
```
DECLARATION OF INTERIM DIVIDEND

RESOLVED THAT an interim dividend of {amount} {currency} per share 
(total: {total_amount} {currency}) be declared for the financial period 
ending {period_end}, payable on {payment_date} to shareholders on 
the register as at {record_date}.
```

**Supplementary document**: Dividend Voucher per shareholder

---

### 13. Update Constitution (更新章程)

**Requires Special Resolution**.

**Board Resolution wording**:
```
AMENDMENT OF CONSTITUTION

RESOLVED THAT the Constitution of the Company be amended as follows:
{description_of_amendments}

RESOLVED THAT the Secretary file the amended Constitution with the 
Registrar of Companies.
```

---

### 14. Update Paid-up Capital (更新实缴资本)

**Board Resolution wording**:
```
UPDATE OF PAID-UP CAPITAL

RESOLVED THAT the paid-up capital of the Company be recorded as 
{new_paid_up_amount} {currency}, reflecting the additional capital 
contribution of {additional_amount} {currency} received on {date}.
```

---

### 15. Particulars Update (个人信息更新)

**NO Board Resolution required**. This is an administrative update only.

Generate a **Notification Letter** instead:
```
To: The Registrar of Companies
ACRA

NOTIFICATION OF CHANGE IN PARTICULARS

Company Name: {company.name}
UEN: {company.uen}

We hereby notify you of the following change(s) in particulars:

Name of person: {person_name}
Change: {change_description}
Old: {old_value}
New: {new_value}
Effective date: {effective_date}

Signed by: _______________
(Company Secretary)
Date: _______________
```

---

## Transfer-In Standard Package

For a **typical transfer-in** where the client selects the 3 standard changes (registered office + secretary + local director), the output is:

```
00_New_Client_Acceptance_Form.docx
  └─ Filled from questionnaire data

01_Board_Resolution_Combined.docx
  └─ Contains 3 merged resolutions:
     [1] CHANGE OF REGISTERED OFFICE
     [2] RESIGNATION OF OLD SECRETARY + APPOINTMENT OF NEW SECRETARY
     [3] APPOINTMENT OF NEW DIRECTOR (if applicable)

02_Form45_{DIRECTOR_NAME}.docx
  └─ Consent to Act as Director (for new local director)

03_Consent_Secretary.docx
  └─ YANG YUJIE's consent to act as secretary

04_Notice_Registered_Office.docx
  └─ Notice of change of registered office

05_Nominee_Director_Agreement.docx
  └─ If the new director is a Yu Young nominee

06_Resignation_Secretary_{OLD_NAME}.docx
  └─ Old secretary's resignation letter

07_Registrable_Controller_Notice.docx
  └─ If registrable controller info needs updating

08_DPO_Form.docx
  └─ If DPO not yet registered (docs.dpo_registered = NO)
```

## Document Formatting Standards

- **Font**: Times New Roman, 12pt body, 14pt bold titles
- **Language**: Bilingual (English + Chinese) for client-facing documents; English-only for statutory forms
- **Legal references**: Always cite the specific Companies Act section
- **Company header**: Company name + UEN on every document
- **Signature blocks**: Name line + Signature line + Date line
- **Board Resolution format**: Company header → Title → "We, the undersigned..." → Resolution items → Director signature blocks
