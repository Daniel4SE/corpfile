# Questionnaire Fields Reference

This document defines all fields from the **Questionnaire for Incorporation (注册公司问卷)** used by Yu Young Consulting (Singapore) Pte. Ltd.

## Section 1: THE COMPANY 公司信息

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `company.name_choices` | Proposed company names | 公司名字 | List (up to 3) | Priority order; ACRA checks availability |
| `company.principal_activities` | Principal activities | 公司主营业务 | Text + SSIC codes | Must map to valid SSIC codes |

## Section 2: COMPANY ASSETS 公司资产

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `company.assets` | Details of assets | 公司资产详情 | Text | "N.A." if none; otherwise buildings, IP, subsidiaries etc. |

## Section 3: SOURCE OF FUNDS 资金来源

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `company.source_of_funds` | Source of funds for start-up | 成立公司的资金来源 | Text | Required for AML/KYC |

## Section 4: GROUP / RELATED COMPANIES 集团或关联公司

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `company.group_name` | Group or related company name | 集团或关联公司名称 | Text | Optional |
| `company.group_website` | Group website | 集团网站 | URL | Optional |

## Section 5: ULTIMATE BENEFICIAL OWNER / REGISTRABLE CONTROLLER 实控人信息

**CRITICAL DECISION POINT**: If UBO is a natural person → fill Part 1 of Document #5. If UBO is a company → fill Part 2.

Each UBO entry has:

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `ubo[].name` | Full name | 姓名 | Text | |
| `ubo[].address` | Residential address | 住址 | Text | |
| `ubo[].id_type` | ID type | 证件类型 | Enum: passport/NRIC/company_reg | |
| `ubo[].id_number` | ID/Passport/Company Reg number | 护照号码/身份证/公司注册号 | Text | |
| `ubo[].email` | Email | 电邮 | Email | |
| `ubo[].mobile` | Mobile number | 电话号码 | Text | |
| `ubo[].is_pep` | Politically exposed person | 是否公职人员 | Boolean | |
| `ubo[].pep_period` | PEP period | 担任公职人员的日期 | Text | Only if is_pep = true |
| `ubo[].verified_method` | Verification method | 视频认证或见过面 | Enum: video/face_to_face | |
| `ubo[].is_natural_person` | Natural person or company | 自然人还是公司 | Boolean | **Key conditional** |

**Supporting documents required per UBO**:
- Singapore company → Certificate of Incorporation
- Offshore company → Certificate of Good Standing + Certificate of Incumbency
- Individual → Passport (color copy) + Address proof (utility bill < 3 months)

## Section 6: SHAREHOLDERS 股东

Each shareholder entry has:

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `shareholders[].name` | Full name | 姓名 | Text | |
| `shareholders[].is_controller` | Is actual controller | 是否实控人 | Boolean | |
| `shareholders[].shares` | Number of shares subscribed | 总股数 | Integer | |
| `shareholders[].price_per_share` | Currency and amount per share | 每股的货币和金额 | Text | e.g. "SGD 1.00" |
| `shareholders[].address` | Residential/Registered address | 住址/登记的公司地址 | Text | |
| `shareholders[].id_number` | Passport/IC/Company Reg | 护照号码/身份证号 | Text | |
| `shareholders[].nationality` | Nationality / Country of incorporation | 国籍/公司注册地 | Text | |
| `shareholders[].email` | Email | 电邮 | Email | |
| `shareholders[].mobile` | Mobile number | 电话号码 | Text | |
| `shareholders[].verified_method` | Verification method | 视频认证或见过面 | Enum | |
| `shareholders[].is_pep` | Politically exposed person | 是否公职人员 | Boolean | |
| `shareholders[].pep_period` | PEP period | 担任公职人员的日期 | Text | |
| `shareholders[].is_company` | Is a company (not individual) | 是否为公司 | Boolean | **If true → Document #8 required** |

## Section 7: CAPITAL STRUCTURE 资本结构

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `capital.share_class` | Class of shares | 股份类别 | Text | Default: "ordinary" |
| `capital.total_shares` | Number of shares at incorporation | 公司注册时的股数 | Integer | |
| `capital.price_per_share` | Price per share | 每股价格 | Decimal | |
| `capital.paid_up_amount` | Amount paid at incorporation | 公司设立时实缴资本 | Decimal | |
| `capital.currency` | Currency | 货币 | Text | Default: "SGD" |

## Section 8: REGISTERED OFFICE 注册办公地址

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `office.use_agent_address` | Use Yu Young's address | 使用代理地址 | Boolean | Default: true → 51 Goldhill Plaza #20-07 Singapore 308900 |
| `office.custom_address` | Custom address | 自定义地址 | Text | Only if use_agent_address = false |

## Section 9: GROUP OPERATING STATUS 集团经营情况

Only required if any shareholder is a company.

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `group.revenue_over_10m` | Annual sales > SGD 10M | 销售额是否大于1000万新币 | Boolean | |
| `group.assets_over_10m` | Total assets > SGD 10M | 总资产是否大于1000万新币 | Boolean | |
| `group.employees_over_50` | Employees > 50 | 员工人数是否大于50人 | Boolean | |

## Section 10: DIRECTORS 董事

At least one director must be "ordinarily resident" in Singapore.

Each director entry has:

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `directors[].name` | Full name | 全名 | Text | |
| `directors[].is_nominee` | Nominee director | 是否代理董事 | Boolean | **If true → Document #7.1 or #7.2** |
| `directors[].id_number` | Passport/IC number | 护照和身份证号码 | Text | |
| `directors[].address` | Permanent residential address | 常住地址 | Text | |
| `directors[].phone` | Telephone | 电话 | Text | |
| `directors[].email` | Email | 电邮 | Text | |
| `directors[].dob` | Date and place of birth | 出生地和出生日期 | Text | |
| `directors[].tax_residence` | Residence for tax purposes | 居住地（纳税地） | Text | |
| `directors[].domicile` | Domicile | 常居地 | Text | |
| `directors[].nationality` | Nationality (all) | 国籍 | Text | |
| `directors[].verified_method` | Verification method | 视频认证或见过面 | Enum | |
| `directors[].is_pep` | Politically exposed person | 是否公职人员 | Boolean | |
| `directors[].pep_period` | PEP period | 担任公职人员的日期 | Text | |
| `directors[].is_sg_resident` | Ordinarily resident in SG | 是否新加坡常驻居民 | Boolean | At least one must be true |

## Section 11: ACCOUNTING AND TAXATION 记账和税务

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `accounting.base_currency` | Preferred accounting currency | 首选会计基础货币 | Text | Default: SGD |
| `accounting.fye` | Financial year end | 首选的会计年度 | Text | e.g. "31 December" |
| `accounting.auditors` | Auditors | 审计师 | Text | Optional |
| `accounting.tax_agent` | Tax agent | 税务师 | Text | Optional |
| `accounting.accountancy` | Accountancy services | 会计服务 | Text | Optional |

## Section 12: BANK ACCOUNT 银行开户信息

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `bank.name` | Bank name | 银行名称 | Text | |
| `bank.currency` | Currency | 货币 | Text | |
| `bank.signatories` | Authorised signatories | 授权签字人 | Text | |
| `bank.operation_mode` | Mode of operation | 业务类型 | Enum: singly/jointly | |
| `bank.mailing_address` | Mailing address | 邮寄地址 | Text | |

## Section 13: KEY CONTACT 主要联系人

| Field ID | Field Name (EN) | Field Name (CN) | Type | Notes |
|----------|-----------------|------------------|------|-------|
| `contact.name` | Contact name | 联系人姓名 | Text | Required |
| `contact.email` | Contact email | 联系人电邮 | Email | Required |
| `contact.phone` | Contact phone | 联系人电话 | Text | Required |

## Section 14: DECLARATION 声明

The declaration is standard text (integrity + AML/source of funds). It does not have variable fields — only the signature block at the end:

| Field ID | Field Name (EN) | Type |
|----------|-----------------|------|
| `declaration.signatory_name` | Signatory name | Text |
| `declaration.date` | Date | Date |

## Post-Incorporation Additional Field

| Field ID | Field Name (EN) | Type | Notes |
|----------|-----------------|------|-------|
| `company.uen` | UEN (Company Registration Number) | Text | Only available after ACRA registration; leave blank for pre-incorporation docs |
| `company.incorporation_date` | Date of incorporation | Date | Only available after ACRA registration |
