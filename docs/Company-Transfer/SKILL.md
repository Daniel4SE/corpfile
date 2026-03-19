---
name: sg-company-transfer-in
description: "Automate Singapore company transfer-in (转入公司) document generation for Yu Young Consulting. Trigger when the user mentions: transferring a company to Yu Young, company transfer in, changing company secretary, onboarding an existing Singapore company, change of registered office/secretary/local director, New Client Acceptance Form, or ACRA corporate changes for a transfer-in client. Also trigger when a Bizfile is uploaded and change documents are needed. Handles: parsing Bizfile/questionnaire, selecting change types, auto-matching to document templates, generating Board Resolutions with smart merging of multiple changes into one resolution, and outputting all required .docx files for signature."
---

# Singapore Company Transfer In — Document Generation Skill

## Overview

This skill automates **Yu Young Consulting (Singapore) Pte. Ltd.**'s corporate secretary workflow for **transferring in existing Singapore companies** — i.e., when a client moves their company secretary services from another provider to Yu Young.

Unlike new company registration (which starts from scratch), transfer-in works with an **already-registered company** that has an existing UEN, directors, shareholders, and Bizfile on record with ACRA.

## The Transfer-In SOP

```
Stage 1: Client provides a transfer-in questionnaire + latest Bizfile from ACRA
Stage 2: Yu Young identifies what needs to change (typically: secretary, registered office, local director)
Stage 3: Generate change documents → client signs → submit to ACRA
Stage 4: ACRA processes changes → get updated Bizfile → complete
```

## Workflow Detail

### Step 1: Collect Input Data

The user will provide one or more of:
- **Latest Bizfile** (PDF from ACRA) — contains current company info
- **New Client Acceptance Form** (filled questionnaire) — see `references/acceptance_form_fields.md`
- **Verbal/chat instructions** — specifying what changes to make

Parse the input to extract:
1. **Company identity**: Company name, UEN, incorporation date
2. **Current state**: Current directors, shareholders, secretary, registered office, constitution details
3. **Desired changes**: Which items the client wants to change

If input is insufficient, ask the user which changes are needed.

### Step 2: Select Change Items

Present the user with the available change types. Read `references/change_types.md` for the full list.

**For a typical transfer-in, the standard changes are:**
1. ✅ **Change registered office** → to Yu Young's address (51 Goldhill Plaza #20-07 Singapore 308900)
2. ✅ **Change secretary** → to YANG YUJIE
3. ⬜ **Change director** → add a local nominee director (only if needed for SG residency requirement)

The user may also select additional changes like:
- Change accounting period
- Change company name
- Change currency
- Change principal activities
- Change registered controller
- Increase/reduce share capital
- Transfer shares
- Update constitution
- Update paid-up capital
- Particulars update

### Step 3: Generate Documents

Read `references/change_types.md` for the complete document mapping per change type.

**CRITICAL RULE — Auto-merge Board Resolutions:**
Many change types require a Board of Directors' Resolution. If the user selects multiple changes that each need a Board Resolution, **merge them into a single combined Board Resolution document** with multiple resolution items, rather than generating separate resolution documents for each change.

> SOP原文: "如果比如都是董事会决议的内容，ai可以做到自动合并文件，在同一个决议上可以决定多个内容"

For each selected change, generate:
1. The **Board Resolution** item (merged into one document)
2. Any **supplementary forms** specific to that change type (e.g., Form 45 for new director, Secretary Consent for new secretary)
3. The **New Client Acceptance Form** (always generated for transfer-in)

### Step 4: Output

Save all generated documents to `/mnt/user-data/outputs/` with clear naming:
```
00_New_Client_Acceptance_Form.docx          (always)
01_Board_Resolution_Combined.docx           (merged resolution for all changes)
02_Form45_{DIRECTOR_NAME}.docx              (if change director)
03_Consent_Secretary.docx                   (if change secretary)
04_Notice_Registered_Office.docx            (if change registered office)
05_Registrable_Controller_Notice.docx       (if change registered controller)
06_Nominee_Director_Agreement.docx          (if adding nominee director)
07_DPO_Form.docx                            (if DPO not yet registered)
08_Letter_of_Resignation_Secretary.docx     (outgoing secretary resignation)
09_Letter_of_Resignation_Director.docx      (if removing a director)
```

Present all files to the user using `present_files`.

## Key Differences from New Company Registration

| Aspect | New Registration | Transfer In |
|--------|-----------------|-------------|
| Company exists? | No → creating new | Yes → already registered |
| UEN available? | No (comes after ACRA) | Yes (from Bizfile) |
| Key input | Questionnaire for Incorporation | Bizfile + New Client Acceptance Form |
| Core action | Generate founding docs | Generate change docs |
| Board Resolution | Post-incorporation only | Central document — one per transfer |
| Secretary change | Appointment (new) | Resignation of old + Appointment of new |
| Merge logic | N/A | Multiple changes → single Board Resolution |

## Important Constants

- **Yu Young Consulting** registered office: **51 Goldhill Plaza #20-07 Singapore 308900**
- **Yu Young** company registration: **201708959M**
- **Default new secretary**: **YANG YUJIE** (杨玉洁)
- **Default new registered office**: Yu Young's address (above)
- All documents are **bilingual** (English/Chinese) where applicable
- **Companies Act (Cap. 50)** governs all forms

## Reference Files

Before generating any documents, **always read these files first**:
- `references/acceptance_form_fields.md` — Field definitions for the New Client Acceptance Form
- `references/change_types.md` — All change types, their document requirements, Board Resolution templates, and field mappings
