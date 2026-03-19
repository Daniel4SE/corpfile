---
name: sg-company-registration
description: "Automate Singapore new company incorporation document generation for Yu Young Consulting's corporate secretary workflow. Use this skill whenever the user mentions: registering a new Singapore company, incorporating a company, company incorporation questionnaire, ACRA registration, generating signing documents for a new company, Form 45, subscriber's consent, director's resolution, registrable controller, nominee director/shareholder register, DPO form, KYC self-declaration, or any task related to Yu Young Consulting's new company setup SOP. Also trigger when the user uploads a completed incorporation questionnaire (PDF or Word) and wants to generate the full set of pre-signing or post-signing documents. This skill handles the end-to-end document generation pipeline: parsing the questionnaire, performing conditional logic (natural person vs corporate UBO, nominee vs non-nominee, corporate vs individual shareholders), and outputting all required .docx files ready for signature."
---

# Singapore New Company Registration — Document Generation Skill

## Overview

This skill automates **Yu Young Consulting (Singapore) Pte. Ltd.**'s corporate secretary workflow for incorporating new Singapore companies under the Companies Act (Cap. 50). 

The workflow has 4 stages:
1. Client fills in the **Questionnaire for Incorporation** (问卷)
2. Based on the questionnaire, generate **pre-incorporation signing documents** (设立前签署文件)
3. After signing, register with **ACRA** → receive **UEN** (公司注册号)
4. Generate **post-incorporation signing documents** (设立后签署文件), which require the UEN

**This skill focuses on Stage 2 and Stage 4** — generating the full set of documents from questionnaire data.

## Workflow

### Step 1: Parse the Questionnaire

Read `references/questionnaire_fields.md` for the complete field mapping.

The questionnaire can arrive as:
- A filled PDF
- A filled .docx
- Structured JSON data
- User-provided key-value pairs in conversation

Extract all fields into a structured data object. If fields are missing, ask the user to provide them before proceeding.

### Step 2: Determine Conditional Logic

Several documents have conditional variants. Read `references/document_map.md` for the full decision tree.

Key decision points:
| Condition | Impact |
|-----------|--------|
| UBO is natural person vs company | Document #5 (Registrable Controller Notice) — fill Part 1 vs Part 2 |
| Nominee director: yes/no | Document #7.1 (individual nominee) vs #7.2 (corporate nominee) — pick one |
| Shareholder is a company | Document #8 (Board Resolution for Corporate Shareholder) is required |
| High-risk KYC client | Document #9 (Self-Declaration Letter) is required |
| Pre-incorporation vs post-incorporation | Post-incorporation docs need UEN filled in |

### Step 3: Generate Documents

Read `references/document_map.md` for the complete list of documents, their templates, and field mappings.

For each document:
1. Read the document_map.md to understand required fields
2. Use `python-docx` to create the document programmatically
3. Fill in all fields from the parsed questionnaire data
4. Save as .docx to the output directory

### Step 4: Output

Save all generated documents to `/mnt/user-data/outputs/` with clear naming:
```
01_Subscribers_Consent.docx
02_Form45_Director_Consent_{DirectorName}.docx
03_Consent_to_Act_as_Secretary.docx
04_Notice_of_Registered_Office.docx
05_Registrable_Controller_Notice.docx
06_Register_of_Nominee_Shareholders.docx
07_Register_of_Nominee_Directors.docx
07.1_Nominee_Director_Agreement_Individual.docx  (or 07.2 if corporate)
08_Corporate_Shareholder_Board_Resolution.docx   (only if shareholder is company)
09_Self_Declaration_Letter.docx                   (only if high-risk KYC)
10_DPO_Data_Collection_Form.docx
11_Directors_Resolution_Post_Incorporation.docx   (post-incorporation, needs UEN)
12_Questionnaire_Filled.docx                      (the filled questionnaire itself)
13_New_Client_Acceptance_Form.docx                (for transfer-in clients)
```

Present all files to the user using `present_files`.

## Important Notes

- **Yu Young Consulting** registered office: 51 Goldhill Plaza #20-07 Singapore 308900
- **Company Secretary**: YANG YUJIE (杨玉洁) — default secretary for all new incorporations
- **Registered Office**: By default, Yu Young's address is used unless client specifies their own
- All documents are **bilingual** (English/Chinese) where applicable
- The **Companies Act (Cap. 50)** governs all forms — particularly Section 173C(a) for Form 45, Section 386AG for Registrable Controller
- For post-incorporation documents, if UEN is not yet available, leave the field as `__________` for manual fill later
- Per the SOP note: "希望可以我们提供问卷后，一次输出所有的需要签字文件，UEN部分可以后续人工修改"

## Reference Files

Before generating any documents, **always read these files first**:
- `references/questionnaire_fields.md` — Complete field definitions from the questionnaire
- `references/document_map.md` — All 13+ document templates with field mappings and conditional logic
