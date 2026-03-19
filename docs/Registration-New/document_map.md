# Document Map — Singapore New Company Registration

This reference defines all documents generated during the incorporation workflow, their conditional triggers, and the exact fields to populate.

## Pre-Incorporation Documents (设立前签署文件)

These are generated BEFORE ACRA registration. UEN is not yet available.

---

### Document #1: Subscriber's Consent (认购人同意书)

**File**: `01_Subscribers_Consent.docx`
**Always generated**: Yes
**Legal basis**: Companies Act

**Content**: Each subscriber (shareholder) signs a statement that they are desirous of being formed into a company. This is the founding document.

**Template structure**:
```
We, the persons whose names, addresses and description hereunto subscribed, 
are desirous of being formed into a Company to be known as {company.name_choices[0]}
in pursuance of this Constitution, and we respectively agree to take the number 
of shares in the capital of the company set opposite our respective names.

[Table]
| Full Name | Address | ID/Passport No. | No. of Shares | Amount per Share | Signature |
|-----------|---------|------------------|---------------|------------------|-----------|
| {shareholders[0].name} | {shareholders[0].address} | {shareholders[0].id_number} | {shareholders[0].shares} | {capital.price_per_share} {capital.currency} | |

Dated this _______ day of _______ 20___
```

**Fields used**: `company.name_choices[0]`, `shareholders[*].name`, `shareholders[*].address`, `shareholders[*].id_number`, `shareholders[*].shares`, `capital.price_per_share`, `capital.currency`

---

### Document #2: Form 45 — Consent to Act as Director (董事同意书)

**File**: `02_Form45_{director_name}.docx` — **One per director**
**Always generated**: Yes (one per director)
**Legal basis**: Companies Act Section 173C(a)

**Content**: ACRA Form 45 — each director consents to act and declares they are not disqualified.

**Template structure**:
```
THE COMPANIES ACT (CHAPTER 50)
Section 173C(a)
CONSENT TO ACT AS DIRECTOR AND STATEMENT OF NON-DISQUALIFICATION
                                                                    FORM 45

Name of Entity: {company.name_choices[0]}
Registration No: __________

I, the undermentioned person, hereby consent to act as a director of the 
abovenamed company with effect from {date} and declare that:

(a) I am not disqualified from acting as a director, in that –
    (i) I am not below 18 years of age...
    (ii) Within 3 years... no disqualification order...
    [standard declarations continue]

(b) I am aware of and undertake to abide by my duties...

Name: {directors[n].name}
Birth: {directors[n].dob}
Address: {directors[n].address}
Email: {directors[n].email}
TEL: {directors[n].phone}
NRIC/Passport/FIN No: {directors[n].id_number}
Nationality: {directors[n].nationality}

Signature: _______________
Dated: _______________
```

**Fields used**: `company.name_choices[0]`, `directors[n].*` (all fields)

---

### Document #3: Consent to Act as Secretary (秘书同意书)

**File**: `03_Consent_Secretary.docx`
**Always generated**: Yes
**Legal basis**: Companies Act Section 171

**Content**: The company secretary consents to act. Default secretary is YANG YUJIE.

**Template structure**:
```
Name of company: {company.name_choices[0]}
Company No: __________

1. I, the undermentioned person, hereby consent to act as a secretary of the 
   abovenamed company with effect from ______ (date of incorporation).

2. I am a qualified person under section 171(1AA) of the Companies Act by 
   virtue of my being — 
   *(iv) a member of the Chartered Secretaries Institute of Singapore.

Name: YANG YUJIE
NRIC: [Yu Young staff ID]
Address: 51 Goldhill Plaza #20-07 Singapore 308900

Signature: _______________
Date: _______________
```

**Fields used**: `company.name_choices[0]`
**Hardcoded**: Secretary name = YANG YUJIE, address = Yu Young office

---

### Document #4: Notice of Registered Office (注册办公地址通知)

**File**: `04_Notice_Registered_Office.docx`
**Always generated**: Yes
**Legal basis**: Companies Act

**Content**: Notice to Registrar of the company's registered office address.

**Template structure**:
```
The Registrar of Companies & Businesses,
Singapore

The abovenamed company hereby gives notice that at the time of incorporation:

its registered office will be situated at:
{office.address}

Company Name: {company.name_choices[0]}

Signature: _______________
Date: _______________
```

**Fields used**: `company.name_choices[0]`, `office.use_agent_address` → if true: "51 Goldhill Plaza #20-07 Singapore 308900", else `office.custom_address`

---

### Document #5: Registrable Controller Notice (实控人通知)

**File**: `05_Registrable_Controller_Notice.docx`
**Always generated**: Yes
**Legal basis**: Companies Act Section 386AG(2)(a)

**CONDITIONAL LOGIC**:
- If UBO is **natural person** (`ubo[].is_natural_person == true`): Fill header + footer + **Part 1 only**
- If UBO is **company** (`ubo[].is_natural_person == false`): Fill header + footer + **Part 2 only**

**Template structure**:
```
FORM OF NOTICE MENTIONED IN SECTION 386AG(2)(a) OF COMPANIES ACT

Date of notice: {date}
Dear {ubo[n].name},

We know or have reasonable grounds to believe that you are a registrable 
controller of {company.name_choices[0]} (the "Company").

This notice is sent under section 386AG(2)(a)...

1. Are you a registrable controller of the Company?
   Your reply: ☑ Yes  □ No

--- PART 1 (Natural Person) ---
Full name: {ubo[n].name}
Date of birth: {ubo[n].dob}
Nationality: {ubo[n].nationality}
Residential address: {ubo[n].address}
Identification: {ubo[n].id_number}
Date became registrable controller: {date}

--- PART 2 (Company) ---
Corporate name: {ubo[n].name}
UEN / Registration No: {ubo[n].id_number}
Place of incorporation: {ubo[n].nationality}
Registered office: {ubo[n].address}
Date became registrable controller: {date}

Signature: _______________
Date: _______________
```

**Fields used**: `company.name_choices[0]`, `ubo[n].*`

---

### Document #6: Register of Nominee Shareholders (代持股东登记册)

**File**: `06_Register_Nominee_Shareholders.docx`
**Always generated**: Yes (even if no nominees — marked as "NIL")

**Template structure**:
```
NAME OF COMPANY: {company.name_choices[0]}
UEN: __________

REGISTER OF NOMINEE SHAREHOLDERS

[Table — filled if any shareholders are nominees, else "NIL"]

Signed by: _______________
{shareholders[n].name} (shareholder)
Date: _______________

IMPORTANT NOTES:
1. A shareholder is a nominee if the shareholder is accustomed or under an 
   obligation (whether formal or informal) to act in accordance with the 
   directions of another person...
```

---

### Document #7: Register of Nominee Directors (代持董事登记册)

**File**: `07_Register_Nominee_Directors.docx`
**Always generated**: Yes (even if no nominees — marked as "NIL")

Same structure as #6 but for directors.

---

### Document #7.1: Nominee Director Agreement — Individual (个人提名董事协议)

**File**: `07.1_Nominee_Director_Agreement_Individual.docx`
**Conditional**: Only if `directors[n].is_nominee == true` AND the nominee is an **individual**
**Choose**: 7.1 (individual) OR 7.2 (corporate) — never both for the same nominee

**Template structure** (bilingual):
```
PRIVATE & CONFIDENTIAL

Dear {shareholders[0].name}

{company.name_choices[0]}
(Registration No: __________)

Agreement for Appointment of Non-Executive Local Resident Director ("Nominee Director")
委任非执行本地董事("提名董事")协议

This letter sets out the nature and scope of my services as a Nominee Director...
本协议列出了我作为公司提名董事的性质和服务范围...

[Standard terms follow — not variable]

Signed: _______________
Name: {nominee_director_name}
Date: _______________
```

---

### Document #7.2: Nominee Director Agreement — Corporate (公司提名董事协议)

**File**: `07.2_Nominee_Director_Agreement_Corporate.docx`
**Conditional**: Only if nominee is a **company** (rare)

Same as 7.1 but adapted for corporate entity as nominee provider.

---

### Document #8: Board Resolution for Corporate Shareholder (公司股东董事会决议)

**File**: `08_Board_Resolution_Corporate_Shareholder.docx`
**Conditional**: Only if **any shareholder is a company** (`shareholders[n].is_company == true`)

**Purpose**: Authorises a representative to act on behalf of the corporate shareholder for share subscription and future signing.

**Template structure** (bilingual):
```
BOARD OF DIRECTORS' RESOLUTION PURSUANT TO THE COMPANY'S CONSTITUTION

I/We, the undersigned, being the Director(s) of {corporate_shareholder.name} 
for the time being, do hereby RESOLVED:

INVESTMENT OF SHARES
THAT the Company do hereby invest shares in the following proposed company:
| Name of Company | No. of Shares |
|-----------------|---------------|
| {company.name_choices[0]} | {shareholders[n].shares} |

APPOINTMENT OF CORPORATE REPRESENTATIVE
THAT the Company do hereby appoint {representative.name} 
(Passport No.: {representative.id_number}, email: {representative.email}) 
as the Company's representative to sign all necessary documents...

Director: _______________
Date: _______________
```

**Fields used**: Corporate shareholder details, `company.name_choices[0]`, representative details

---

### Document #9: Self-Declaration Letter (自我声明书)

**File**: `09_Self_Declaration_Letter.docx`
**Conditional**: Only if client is flagged as **high-risk KYC** (KYC高风险对象)

**Template structure** (bilingual):
```
{date}

To whom it may concern,

LETTER OF SELF-DECLARATION

I, {ubo[n].name}, [Passport Number: {ubo[n].id_number}], hereby declare, 
warrant and represent that:

I am the beneficial owner, director, shareholder, officer and representative 
of {company.name_choices[0]} PTE LTD (UEN: __________), and I confirm that...

[Standard AML/source of funds declarations]

Signature: _______________
Name: {ubo[n].name}
Date: _______________
```

---

### Document #10: DPO Data Collection Form (数据保护官信息表)

**File**: `10_DPO_Form.docx`
**Always generated**: Yes
**Legal basis**: Personal Data Protection Act 2012 (PDPA)

**Template structure** (bilingual):
```
DATA PROTECTION OFFICER (DPO) UNDER PERSONAL DATA PROTECTION ACT 2012
数据保护官《2012年个人数据保护法》

DPO DATA COLLECTION FORM  DPO信息收集表

COMPANY NAME: {company.name_choices[0]}
UEN: __________

In compliance with PDPA 2012, an organization must designate at least one DPO...

DPO Name (*): {contact.name}
DPO Email (*): {contact.email}
DPO Phone (*): {contact.phone}
DPO Address: {office.address}
```

---

## Post-Incorporation Documents (设立后签署文件)

These are generated AFTER ACRA registration. **UEN is required** — if not available, leave as `__________`.

---

### Document #11: Director's Resolutions in Writing (董事书面决议)

**File**: `11_Directors_Resolution.docx`
**Always generated**: Yes (post-incorporation)
**This is the most comprehensive post-incorporation document**

**Template structure**:
```
{company.name_choices[0]}
Company Registration No. {company.uen}
Incorporated in the Republic of Singapore

DIRECTOR'S RESOLUTIONS IN WRITING
PURSUANT TO THE COMPANY'S CONSTITUTION

INCORPORATION
It was noted that the Company was duly incorporated in Singapore on 
{company.incorporation_date}. The relevant Certificate Confirming 
Incorporation was tabled...

CONFIRMATION OF FIRST DIRECTORS
RESOLVED THAT {directors[*].name (comma separated)} be confirmed as 
Directors of the Company with effect from the date of incorporation.

SELECTION OF THE CHAIRMAN OF THE BOARD
RESOLVED THAT {directors[0].name} be selected as the chairman of the Board.

REGISTERED OFFICE
RESOLVED that the registered office of the Company be situated at 
{office.address} with effect from the date of incorporation.

ISSUE OF SHARES TO SUBSCRIBERS
RESOLVED that the allotment of shares in the Company to the following 
subscriber(s) be confirmed:
| Name | No. of Shares | Amount per Share |
|------|---------------|------------------|
| {shareholders[*]} | {shares} | {price} |

RESOLVED that share certificates be issued to the aforementioned subscribers...

CONFIRMATION AND APPOINTMENT OF SECRETARY
RESOLVED THAT the appointment of YANG YUJIE as Secretary of the Company 
with effect from the date of incorporation be hereby confirmed.

FINANCIAL YEAR END
RESOLVED THAT the first financial period of the Company be from the date 
of incorporation to {accounting.fye}, and thereafter the financial year 
shall end on {accounting.fye} each year.

DIRECTORS:
{directors[0].name}          {directors[1].name}
_______________               _______________
Date: _______________
```

**Fields used**: `company.uen`, `company.incorporation_date`, `company.name_choices[0]`, `directors[*].*`, `shareholders[*].*`, `capital.*`, `office.address`, `accounting.fye`

---

### Document #12: Filled Questionnaire (已填问卷)

**File**: `12_Questionnaire_Filled.docx`
**Always generated**: Yes
**Purpose**: Archive copy of the questionnaire with all client data filled in

This is a complete reproduction of the original Questionnaire for Incorporation with all 14 sections populated from the parsed data. Include the Yu Young letterhead.

---

### Document #13: New Client Acceptance Form (新客户接受表)

**File**: `13_New_Client_Acceptance_Form.docx`
**Always generated**: Yes (for new incorporations)

**Template structure** (bilingual):
```
NEW CLIENT ACCEPTANCE FORM 新客户接受表

Client Name: {company.name_choices[0]} Pte. Ltd.
Company Reg No: {company.uen}

[Checklist of provided documents]
| Item | YES/NO |
|------|--------|
| Shareholder's ID or Passport | |
| Proof of address (< 3 months) for shareholder | |
| Director's ID or Passport | |
| Proof of address (< 3 months) for director | |
| Has your company registered the DPO | |
| Financial year end | {accounting.fye} |

Contact person (Required):
Full Name: {contact.name}
Email: {contact.email}
Phone: {contact.phone}

ULTIMATE BENEFICIAL OWNER information:
[UBO table from Section 5]

Declaration:
[Standard integrity + AML declaration]

Signature: _______________
Name: _______________
Date: _______________
```

---

## Decision Tree Summary

```
START
│
├─ ALWAYS generate: #1, #2 (×N directors), #3, #4, #5, #6, #7, #10
│
├─ IF ubo[].is_natural_person:
│   └─ #5 → fill Part 1
├─ ELSE (ubo is company):
│   └─ #5 → fill Part 2
│
├─ IF any director is nominee:
│   ├─ IF nominee is individual → generate #7.1
│   └─ IF nominee is corporate → generate #7.2
│
├─ IF any shareholder is company:
│   └─ generate #8 (one per corporate shareholder)
│
├─ IF high-risk KYC:
│   └─ generate #9
│
├─ POST-INCORPORATION (when UEN available):
│   └─ generate #11, #12, #13
│   └─ also update UEN field in #5, #6, #7, #10
│
└─ END — present all files to user
```

## File Naming Convention

All files should be named with number prefix for sorting:
- `01_Subscribers_Consent.docx`
- `02_Form45_CHEN_YINJIA.docx` (use director name in caps, underscore-separated)
- `02_Form45_CHEN_JUN.docx`
- `03_Consent_Secretary.docx`
- `04_Notice_Registered_Office.docx`
- `05_Registrable_Controller_Notice.docx`
- `06_Register_Nominee_Shareholders.docx`
- `07_Register_Nominee_Directors.docx`
- `07.1_Nominee_Director_Agreement.docx` (if applicable)
- `08_Board_Resolution_{CORPORATE_NAME}.docx` (if applicable)
- `09_Self_Declaration_{NAME}.docx` (if applicable)
- `10_DPO_Form.docx`
- `11_Directors_Resolution.docx` (post-incorporation)
- `12_Questionnaire_Filled.docx`
- `13_New_Client_Acceptance_Form.docx`

## Document Formatting Standards

- **Font**: Times New Roman, 12pt for body, 14pt bold for titles
- **Language**: Bilingual (English + Chinese) for client-facing documents
- **Legal references**: Always cite the specific Companies Act section
- **Signature blocks**: Include Name, Signature line, Date line
- **Company name**: Always use the first-choice name from the questionnaire
- **UEN**: Use `__________` as placeholder if not yet available
