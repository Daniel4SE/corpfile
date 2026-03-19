# New Client Acceptance Form — Field Reference

This document defines all fields from the **New Client Acceptance Form (新客户接受表)** used by Yu Young Consulting for company transfer-in.

## Header Section

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `company.name` | Client Name | 客户公司名称 | Text | Full registered name with "Pte. Ltd." |
| `company.uen` | Company Reg No | 公司注册号 | Text | UEN from Bizfile |
| `bizfile.date` | Bizfile date | 商业档案日期 | Date | Date of the ACRA Bizfile provided |

## Bizfile Accuracy Check

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `bizfile.is_accurate` | Information is accurate | 信息是正确的 | Boolean | If true, no updates needed |
| `bizfile.updates[]` | Items to update | 需要更新的信息 | Array of {field, new_value} | See table below |

**Bizfile update table format:**

| Information in Business Profile need to be updated (商业档案需要更新的信息) | Updated information (信息更新为) |
|---|---|
| {field description} | {new value} |

## Document Checklist

| Field ID | Field Name (EN/CN) | Type | Notes |
|----------|---------------------|------|-------|
| `docs.shareholder_id` | Shareholder's ID or Passport (股东身份证件或护照) | YES/NO | |
| `docs.shareholder_address_proof` | Proof of address < 3 months for shareholder (股东3个月内有效的地址证明) | YES/NO | |
| `docs.director_id` | Director's ID or Passport (董事身份证件或护照) | YES/NO | Note: original form has typo "Shareholder's" for the 3rd row — it means Director |
| `docs.director_address_proof` | Proof of address < 3 months for director (董事3个月内有效的地址证明) | YES/NO | |
| `docs.dpo_registered` | Has company registered the DPO (是否已登记DPO) | YES/NO | If NO → generate DPO form |
| `docs.fye` | Financial year end (公司财务年度日) | Text | e.g., "31 December" |

## Contact Information (联系方式)

### Primary Contact (第一联系人 — 必填)

| Field ID | Field Name (EN) | Field Name (CN) | Type |
|----------|-----------------|------------------|------|
| `contact.primary.name` | Full Name | 全名 | Text |
| `contact.primary.address` | Residential and Contact Address | 常住通讯住址 | Text |
| `contact.primary.phone` | Telephone | 电话 | Text |
| `contact.primary.email` | Email | 电邮 | Email |
| `contact.primary.dob` | Date of Birth | 出生日期 | Date |
| `contact.primary.nationality` | Nationality (all) | 国籍 | Text |
| `contact.primary.id_type` | Passport or IC | 护照或身份证 | Text |
| `contact.primary.id_number` | Passport or IC number | 护照/身份证号码 | Text |

*Supporting docs: Clear colour copy of Singapore NRIC or current valid Passport; address proof < 3 months.*

### Emergency Contact (紧急联系人 — 必填)

| Field ID | Field Name (EN) | Field Name (CN) | Type |
|----------|-----------------|------------------|------|
| `contact.emergency.name` | Full Name | 全名 | Text |
| `contact.emergency.address` | Residential and Contact Address | 常住通讯住址 | Text |
| `contact.emergency.phone` | Telephone | 电话 | Text |
| `contact.emergency.email` | Email | 电邮 | Email |
| `contact.emergency.dob` | Date of Birth | 出生日期 | Date |
| `contact.emergency.nationality` | Nationality (all) | 国籍 | Text |
| `contact.emergency.id_number` | Identification number | 身份证号码 | Text |

## Ultimate Beneficial Owner / Registrable Controller (最终受益人/实控人信息)

Each UBO entry:

| Field ID | Field Name (EN) | Field Name (CN) | Type |
|----------|-----------------|------------------|------|
| `ubo[].name` | Name | 姓名 | Text |
| `ubo[].address` | Residential Address | 住址 | Text |
| `ubo[].id_number` | Passport/IC/Company Reg No | 护照号码/身份证号码/公司注册号码 | Text |
| `ubo[].email` | Email | 电邮 | Email |
| `ubo[].mobile` | Mobile number | 电话号码 | Text |
| `ubo[].verified_method` | Verification method | 视频认证或见过面 | Enum |
| `ubo[].is_pep` | Politically exposed person | 是否公职人员 | Boolean |
| `ubo[].pep_period` | PEP period | 担任公职人员的日期 | Text |

## Declaration Section (声明)

Standard bilingual declaration covering:
1. **Integrity (诚信声明)** — person of integrity, will settle all monies owed to Yu Young
2. **Source of property, solvency, beneficial ownership (财产来源、偿付能力、资产所有权)**:
   - No AML/drug trafficking/terrorism concerns
   - Remains solvent after contribution
   - Assets are free from charges/liens
   - Contributions are of free will

**Signature block:**

| Field ID | Type |
|----------|------|
| `declaration.signature` | Signature line |
| `declaration.name` | Text |
| `declaration.designation` | Text (职位) |
| `declaration.date` | Date |

## Changes Requested (变更项目)

This is the critical field for the transfer-in workflow. The client indicates which corporate changes they need. See `change_types.md` for the full list of available change types and their document mappings.

| Field ID | Field Name | Type | Notes |
|----------|------------|------|-------|
| `changes_requested[]` | List of change types | Array of Enum | Selected from the master list of 15 change types |

For a **standard transfer-in**, the typical selections are:
- `change_registered_office`
- `change_secretary`
- `change_director` (if local director needed)
