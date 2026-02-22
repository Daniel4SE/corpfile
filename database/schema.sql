-- ================================================================
-- Corporate Secretarial System - Database Schema
-- Clone of teamwork.sg
-- ================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `corporate_secretary` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `corporate_secretary`;

-- ================================================================
-- 1. AUTHENTICATION & USER MANAGEMENT
-- ================================================================

CREATE TABLE `clients` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` VARCHAR(50) NOT NULL UNIQUE COMMENT 'e.g. SG123',
  `company_name` VARCHAR(255) NOT NULL,
  `logo` VARCHAR(500) DEFAULT NULL,
  `status` TINYINT DEFAULT 1 COMMENT '1=active,0=inactive',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `role` ENUM('superadmin','admin','user','viewer') DEFAULT 'user',
  `user_group_id` INT UNSIGNED DEFAULT NULL,
  `profile_image` VARCHAR(500) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_client_username` (`client_id`, `username`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `oauth_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `provider` VARCHAR(50) NOT NULL COMMENT 'google, microsoft, etc.',
  `provider_uid` VARCHAR(255) NOT NULL COMMENT 'Firebase UID or provider user ID',
  `email` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `avatar` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_provider_uid` (`provider`, `provider_uid`)
) ENGINE=InnoDB;

CREATE TABLE `user_groups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `group_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `user_group_permissions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_group_id` INT UNSIGNED NOT NULL,
  `module` VARCHAR(100) NOT NULL,
  `can_view` TINYINT DEFAULT 0,
  `can_create` TINYINT DEFAULT 0,
  `can_edit` TINYINT DEFAULT 0,
  `can_delete` TINYINT DEFAULT 0,
  FOREIGN KEY (`user_group_id`) REFERENCES `user_groups`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `user_page_access` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `page_name` VARCHAR(255) NOT NULL,
  `has_access` TINYINT DEFAULT 0,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `user_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `action` VARCHAR(255) NOT NULL,
  `module` VARCHAR(100) DEFAULT NULL,
  `record_id` INT UNSIGNED DEFAULT NULL,
  `log_change` TEXT DEFAULT NULL,
  `remarks` TEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 2. INDIVIDUALS / MEMBERS
-- ================================================================

CREATE TABLE `members` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `name_initials` VARCHAR(10) DEFAULT NULL COMMENT 'Dr/Mr/Mrs/Ms/etc',
  `name` VARCHAR(255) NOT NULL,
  `former_name` VARCHAR(255) DEFAULT NULL,
  `alias_name` VARCHAR(255) DEFAULT NULL,
  `gender` ENUM('Male','Female') DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `country_of_birth` VARCHAR(100) DEFAULT NULL,
  `nationality` VARCHAR(100) DEFAULT NULL,
  `race` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Active',
  `risk_assessment_rating` VARCHAR(20) DEFAULT NULL,
  `additional_notes` TEXT DEFAULT NULL,
  `deceased_date` DATE DEFAULT NULL,
  `resigning` VARCHAR(255) DEFAULT NULL,
  `father_name` VARCHAR(255) DEFAULT NULL,
  `mother_name` VARCHAR(255) DEFAULT NULL,
  `spouse_name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `alternate_email` VARCHAR(255) DEFAULT NULL,
  `skype_id` VARCHAR(100) DEFAULT NULL,
  `mobile_code` VARCHAR(10) DEFAULT NULL,
  `mobile_number` VARCHAR(50) DEFAULT NULL,
  `telephone_code` VARCHAR(10) DEFAULT NULL,
  `telephone_number` VARCHAR(50) DEFAULT NULL,
  `fax_code` VARCHAR(10) DEFAULT NULL,
  `fax_number` VARCHAR(50) DEFAULT NULL,
  `preferred_contact_mode` VARCHAR(50) DEFAULT NULL,
  `business_occupation` TEXT DEFAULT NULL,
  `other_directorship` TEXT DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `member_identifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `member_id` INT UNSIGNED NOT NULL,
  `id_type` VARCHAR(50) NOT NULL COMMENT 'NRIC/Passport/FIN/etc',
  `id_number` VARCHAR(100) NOT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `issued_date` DATE DEFAULT NULL,
  `expired_date` DATE DEFAULT NULL,
  `file_path` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 3. ADDRESSES (shared by companies and members)
-- ================================================================

CREATE TABLE `addresses` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `entity_type` ENUM('company','member') NOT NULL,
  `entity_id` INT UNSIGNED NOT NULL,
  `address_type` VARCHAR(50) DEFAULT 'Registered Office' COMMENT 'Registered/Foreign/Local/Alt Local/Alt Foreign/Business',
  `is_default` TINYINT DEFAULT 0,
  `care_of` VARCHAR(255) DEFAULT NULL,
  `block` VARCHAR(50) DEFAULT NULL,
  `address_text` TEXT DEFAULT NULL,
  `building` VARCHAR(255) DEFAULT NULL,
  `level` VARCHAR(20) DEFAULT NULL,
  `unit` VARCHAR(20) DEFAULT NULL,
  `country` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `postal_code` VARCHAR(20) DEFAULT NULL,
  `proof_file` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_entity` (`entity_type`, `entity_id`)
) ENGINE=InnoDB;

-- ================================================================
-- 4. COMPANIES
-- ================================================================

CREATE TABLE `company_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `type_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `companies` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_name` VARCHAR(500) NOT NULL,
  `former_name` VARCHAR(500) DEFAULT NULL,
  `trading_name` VARCHAR(500) DEFAULT NULL,
  `company_id_code` VARCHAR(100) DEFAULT NULL COMMENT 'Company ID field',
  `company_type_id` INT UNSIGNED DEFAULT NULL,
  `registration_number` VARCHAR(100) DEFAULT NULL COMMENT 'Local/Foreign reg number',
  `acra_registration_number` VARCHAR(100) DEFAULT NULL COMMENT 'ACRA UEN',
  `country` VARCHAR(100) DEFAULT 'SINGAPORE',
  `region_id` INT UNSIGNED DEFAULT NULL,
  `incorporation_date` DATE DEFAULT NULL,
  `entity_status` VARCHAR(50) DEFAULT 'Active' COMMENT 'ACRA status',
  `internal_css_status` VARCHAR(50) DEFAULT NULL COMMENT 'Pre-Incorp/Active/Terminated/Dormant/etc',
  `risk_assessment_rating` VARCHAR(20) DEFAULT NULL,
  `common_seal` VARCHAR(10) DEFAULT NULL,
  `company_stamp` VARCHAR(10) DEFAULT NULL,
  `related_industry_id` INT UNSIGNED DEFAULT NULL,
  `market_segment_id` INT UNSIGNED DEFAULT NULL,
  `public_interest_company` VARCHAR(10) DEFAULT NULL,
  `legis_entity_name` VARCHAR(255) DEFAULT NULL,
  `jurisdiction_incorp_name` VARCHAR(255) DEFAULT NULL,
  `jurisdiction_corp_name` VARCHAR(255) DEFAULT NULL,
  `jurisdiction_corp_id` VARCHAR(100) DEFAULT NULL,
  `strike_off_date` DATE DEFAULT NULL,
  `liquid_strike_off_date` DATE DEFAULT NULL,
  `terminate_date` DATE DEFAULT NULL,
  `dormant_date` DATE DEFAULT NULL,
  `liquidated_date` DATE DEFAULT NULL,
  -- Activities (SSIC)
  `activity_1` VARCHAR(100) DEFAULT NULL,
  `activity_1_desc_default` TEXT DEFAULT NULL,
  `activity_1_desc_user` TEXT DEFAULT NULL,
  `activity_2` VARCHAR(100) DEFAULT NULL,
  `activity_2_desc_default` TEXT DEFAULT NULL,
  `activity_2_desc_user` TEXT DEFAULT NULL,
  -- Share Capital
  `ord_issued_share_capital` DECIMAL(20,2) DEFAULT 0,
  `ord_currency` VARCHAR(10) DEFAULT 'SGD',
  `no_ord_shares` INT DEFAULT 0,
  `paid_up_capital` DECIMAL(20,2) DEFAULT 0,
  `paid_up_capital_currency` VARCHAR(10) DEFAULT 'SGD',
  `spec_issued_share_capital` DECIMAL(20,2) DEFAULT 0,
  `spec_currency` VARCHAR(10) DEFAULT 'SGD',
  `no_spec_shares` INT DEFAULT 0,
  -- FYE / AGM / AR
  `fye_date` DATE DEFAULT NULL,
  `financial_date` DATE DEFAULT NULL,
  `next_agm_due` DATE DEFAULT NULL,
  `date_of_agm` DATE DEFAULT NULL,
  `date_of_ar` DATE DEFAULT NULL,
  `last_ar_filing` DATE DEFAULT NULL,
  -- Contact
  `contact_person` VARCHAR(255) DEFAULT NULL,
  `auditor_name` VARCHAR(255) DEFAULT NULL,
  `phone1_code` VARCHAR(10) DEFAULT '65',
  `phone1_number` VARCHAR(50) DEFAULT NULL,
  `phone2_code` VARCHAR(10) DEFAULT '65',
  `phone2_number` VARCHAR(50) DEFAULT NULL,
  `fax_code` VARCHAR(10) DEFAULT '65',
  `fax_number` VARCHAR(50) DEFAULT NULL,
  `website` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  -- Bank
  `bank_name_id` INT UNSIGNED DEFAULT NULL,
  `bank_account_number` VARCHAR(100) DEFAULT NULL,
  -- Service
  `service_name_id` INT UNSIGNED DEFAULT NULL,
  `service_appoint_date` DATE DEFAULT NULL,
  `service_termination_date` DATE DEFAULT NULL,
  `service_status` VARCHAR(50) DEFAULT NULL,
  -- Comments
  `remarks` TEXT DEFAULT NULL,
  `additional_remarks` TEXT DEFAULT NULL,
  -- Logo
  `logo` VARCHAR(500) DEFAULT NULL,
  -- Client type flags
  `is_css_client` TINYINT DEFAULT 1,
  `is_taxation_client` TINYINT DEFAULT 0,
  `is_accounting_client` TINYINT DEFAULT 0,
  `is_audit_client` TINYINT DEFAULT 0,
  `is_outsrc_accounting` TINYINT DEFAULT 0,
  `is_outsrc_tax` TINYINT DEFAULT 0,
  `is_payroll_client` TINYINT DEFAULT 0,
  `is_compilation_client` TINYINT DEFAULT 0,
  `is_ask_client` TINYINT DEFAULT 0,
  `is_m_and_a_client` TINYINT DEFAULT 0,
  `is_hr_client` TINYINT DEFAULT 0,
  `is_scrutinisation_client` TINYINT DEFAULT 0,
  `is_gst_client` TINYINT DEFAULT 0,
  `is_wp_ep_client` TINYINT DEFAULT 0,
  `is_commercial_accounting` TINYINT DEFAULT 0,
  `is_personal_tax` TINYINT DEFAULT 0,
  `is_auditor` TINYINT DEFAULT 0,
  `is_corporate_shareholder` TINYINT DEFAULT 0,
  `is_fund_management` TINYINT DEFAULT 0,
  `is_corporate_director` TINYINT DEFAULT 0,
  `is_corporate_owner` TINYINT DEFAULT 0,
  `is_external_corp_sec` TINYINT DEFAULT 0,
  `is_sub_fund` TINYINT DEFAULT 0,
  `is_agent` TINYINT DEFAULT 0,
  `is_corporate_controller` TINYINT DEFAULT 0,
  `is_corporate_partner` TINYINT DEFAULT 0,
  `is_representative_office` TINYINT DEFAULT 0,
  `is_odi` TINYINT DEFAULT 0,
  `is_resident_representative` TINYINT DEFAULT 0,
  `is_liquidator` TINYINT DEFAULT 0,
  `is_hrs_client` TINYINT DEFAULT 0,
  `is_trust_fund` TINYINT DEFAULT 0,
  -- Segregation
  `is_prospect` TINYINT DEFAULT 0,
  `is_client` TINYINT DEFAULT 1,
  `is_non_client` TINYINT DEFAULT 0,
  -- Metadata
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE,
  KEY `idx_company_name` (`company_name`(100)),
  KEY `idx_registration` (`registration_number`),
  KEY `idx_acra` (`acra_registration_number`)
) ENGINE=InnoDB;

CREATE TABLE `company_pic` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `company_groups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `group_id` INT UNSIGNED NOT NULL,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `company_holding` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `holding_company_id` INT UNSIGNED NOT NULL,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 5. OFFICIALS (Directors, Shareholders, Secretary, etc.)
-- ================================================================

CREATE TABLE `directors` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED DEFAULT NULL COMMENT 'Link to individual',
  `role` VARCHAR(50) DEFAULT 'director' COMMENT 'director/ceo/contact_person/chair_person/etc',
  `name` VARCHAR(255) NOT NULL,
  `id_type` VARCHAR(50) DEFAULT NULL,
  `id_number` VARCHAR(100) DEFAULT NULL,
  `id_expired_date` DATE DEFAULT NULL,
  `nationality` VARCHAR(100) DEFAULT NULL,
  `local_address` TEXT DEFAULT NULL,
  `foreign_address` TEXT DEFAULT NULL,
  `alt_local_address` TEXT DEFAULT NULL,
  `alt_foreign_address` TEXT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `business_occupation` TEXT DEFAULT NULL,
  `other_directorship` TEXT DEFAULT NULL,
  `is_nominee` TINYINT DEFAULT 0,
  `is_registered_controller` TINYINT DEFAULT 0,
  `appointment_proposed_or_effective` VARCHAR(20) DEFAULT 'effective',
  `date_of_appointment` DATE DEFAULT NULL,
  `cessation_proposed_or_effective` VARCHAR(20) DEFAULT 'effective',
  `date_of_cessation` DATE DEFAULT NULL,
  `company_email` VARCHAR(255) DEFAULT NULL,
  `company_contact_code` VARCHAR(10) DEFAULT NULL,
  `company_contact_number` VARCHAR(50) DEFAULT NULL,
  `company_telephone_code` VARCHAR(10) DEFAULT NULL,
  `company_telephone_number` VARCHAR(50) DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  KEY `idx_member` (`member_id`)
) ENGINE=InnoDB;

CREATE TABLE `shareholders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED DEFAULT NULL,
  `shareholder_type` ENUM('Individual','Corporate') NOT NULL DEFAULT 'Individual',
  `name` VARCHAR(255) NOT NULL,
  `id_type` VARCHAR(50) DEFAULT NULL,
  `id_number` VARCHAR(100) DEFAULT NULL,
  `id_expired_date` DATE DEFAULT NULL,
  `nationality` VARCHAR(100) DEFAULT NULL,
  `local_address` TEXT DEFAULT NULL,
  `foreign_address` TEXT DEFAULT NULL,
  `alt_local_address` TEXT DEFAULT NULL,
  `alt_foreign_address` TEXT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  -- Corporate shareholder fields
  `corp_company_type` VARCHAR(100) DEFAULT NULL,
  `corp_reg_address` TEXT DEFAULT NULL,
  `corp_incorporation_date` DATE DEFAULT NULL,
  `corp_foreign_address` TEXT DEFAULT NULL,
  `corp_country` VARCHAR(100) DEFAULT NULL,
  `corp_status` VARCHAR(50) DEFAULT NULL,
  -- Appointment
  `appointment_proposed_or_effective` VARCHAR(20) DEFAULT 'effective',
  `date_of_appointment` DATE DEFAULT NULL,
  `cessation_proposed_or_effective` VARCHAR(20) DEFAULT 'effective',
  `date_of_cessation` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  KEY `idx_member` (`member_id`)
) ENGINE=InnoDB;

CREATE TABLE `secretaries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED DEFAULT NULL,
  `secretary_type` ENUM('Individual','Corporate') DEFAULT 'Individual',
  `name` VARCHAR(255) NOT NULL,
  `id_type` VARCHAR(50) DEFAULT NULL,
  `id_number` VARCHAR(100) DEFAULT NULL,
  `id_expired_date` DATE DEFAULT NULL,
  `nationality` VARCHAR(100) DEFAULT NULL,
  `local_address` TEXT DEFAULT NULL,
  `foreign_address` TEXT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `date_of_appointment` DATE DEFAULT NULL,
  `date_of_cessation` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `auditors` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `firm_name` VARCHAR(255) DEFAULT NULL,
  `registration_number` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `date_of_appointment` DATE DEFAULT NULL,
  `date_of_cessation` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `controllers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `id_type` VARCHAR(50) DEFAULT NULL,
  `id_number` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `date_of_appointment` DATE DEFAULT NULL,
  `date_of_cessation` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Generic officials table for all other officer types
CREATE TABLE `company_officials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `member_id` INT UNSIGNED DEFAULT NULL,
  `official_type` VARCHAR(50) NOT NULL COMMENT 'manager/representative/owner/nominee_trustee/data_protection/fund_manager/agent/liquidator/partner/president/treasurer/commissioner/legal_rep/supervisor/general_manager/resident_rep/chief_representative/deputy_representative/ep_holder/dp_holder/corporate_representative/tax_agent',
  `name` VARCHAR(255) NOT NULL,
  `id_type` VARCHAR(50) DEFAULT NULL,
  `id_number` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `contact_number` VARCHAR(50) DEFAULT NULL,
  `date_of_appointment` DATE DEFAULT NULL,
  `date_of_cessation` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  KEY `idx_type` (`official_type`)
) ENGINE=InnoDB;

-- ================================================================
-- 6. SHARES
-- ================================================================

CREATE TABLE `share_classes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `class_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `company_shares` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `shareholder_id` INT UNSIGNED DEFAULT NULL,
  `currency` VARCHAR(10) DEFAULT 'SGD',
  `share_type` VARCHAR(50) DEFAULT 'Ordinary',
  `share_class_id` INT UNSIGNED DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT NULL COMMENT 'Allotment/Transfer/etc',
  `number_of_shares` INT DEFAULT 0,
  `issued_share_capital` DECIMAL(20,2) DEFAULT 0,
  `paid_up_capital` DECIMAL(20,2) DEFAULT 0,
  `unpaid_capital` DECIMAL(20,2) DEFAULT 0,
  `consideration` DECIMAL(20,2) DEFAULT 0,
  `transaction_date` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 7. EVENTS / AGM / AR / FYE
-- ================================================================

CREATE TABLE `event_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `event_name` VARCHAR(255) NOT NULL,
  `is_recurring` TINYINT DEFAULT 0,
  `recurring_interval` INT DEFAULT NULL COMMENT 'months',
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `company_events` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `event_type_id` INT UNSIGNED DEFAULT NULL,
  `event_type` VARCHAR(50) DEFAULT 'AGM' COMMENT 'AGM/AR/Resolution/Event',
  `fye_year` VARCHAR(10) DEFAULT NULL,
  `fye_date` DATE DEFAULT NULL,
  `actual_fye` DATE DEFAULT NULL,
  `fye_month` VARCHAR(20) DEFAULT NULL,
  `agm_due_date` DATE DEFAULT NULL,
  `agm_held_date` DATE DEFAULT NULL,
  `agm_extended_due_date` DATE DEFAULT NULL,
  `ar_due_date` DATE DEFAULT NULL,
  `ar_filing_date` DATE DEFAULT NULL,
  `ar_extended_due_date` DATE DEFAULT NULL,
  `event_date` DATE DEFAULT NULL,
  `event_description` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Pending',
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 8. DOCUMENTS & TEMPLATES
-- ================================================================

CREATE TABLE `document_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `category_name` VARCHAR(255) NOT NULL,
  `parent_id` INT UNSIGNED DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `entity_type` ENUM('company','member','general') DEFAULT 'company',
  `entity_id` INT UNSIGNED DEFAULT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `document_name` VARCHAR(500) NOT NULL,
  `file_path` VARCHAR(1000) NOT NULL,
  `file_type` VARCHAR(50) DEFAULT NULL,
  `file_size` INT DEFAULT 0,
  `uploaded_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `form_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `category_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `form_templates` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `template_name` VARCHAR(500) NOT NULL,
  `template_content` LONGTEXT DEFAULT NULL,
  `file_path` VARCHAR(1000) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 9. ESIGN
-- ================================================================

CREATE TABLE `esign_documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `document_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(500) NOT NULL,
  `signers` JSON DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Draft',
  `unique_key` VARCHAR(100) DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 10. NOTIFICATIONS
-- ================================================================

CREATE TABLE `notifications` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT DEFAULT NULL,
  `link` VARCHAR(500) DEFAULT NULL,
  `is_read` TINYINT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 11. SETTINGS / MASTER TABLES
-- ================================================================

CREATE TABLE `settings_general` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT DEFAULT NULL,
  UNIQUE KEY `uk_client_key` (`client_id`, `setting_key`),
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `branches` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `branch_name` VARCHAR(255) NOT NULL,
  `address` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `member_id_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `type_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `fee_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `fee_name` VARCHAR(255) NOT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT 0,
  `currency` VARCHAR(10) DEFAULT 'SGD',
  `description` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `product_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `category_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `company_fees` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `fee_type_id` INT UNSIGNED DEFAULT NULL,
  `fee_name` VARCHAR(255) DEFAULT NULL,
  `amount` DECIMAL(12,2) DEFAULT 0,
  `currency` VARCHAR(10) DEFAULT 'SGD',
  `effective_date` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `regions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `region_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `banks` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `bank_name` VARCHAR(255) NOT NULL,
  `bank_code` VARCHAR(50) DEFAULT NULL,
  `swift_code` VARCHAR(50) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `company_bank_accounts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT UNSIGNED NOT NULL,
  `bank_id` INT UNSIGNED DEFAULT NULL,
  `account_number` VARCHAR(100) DEFAULT NULL,
  `account_type_id` INT UNSIGNED DEFAULT NULL,
  `currency` VARCHAR(10) DEFAULT 'SGD',
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `account_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `type_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `payment_modes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `mode_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `industries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `industry_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `market_segments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `segment_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `tags` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `tag_name` VARCHAR(255) NOT NULL,
  `tag_type` VARCHAR(50) DEFAULT 'general',
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `status_master` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `status_name` VARCHAR(100) NOT NULL,
  `status_type` VARCHAR(50) DEFAULT 'general',
  `color` VARCHAR(20) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `group_master` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `group_name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `designations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `designation_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `register_footers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `register_type` VARCHAR(100) NOT NULL,
  `footer_text` TEXT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `custom_fields` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `field_name` VARCHAR(255) NOT NULL,
  `field_type` VARCHAR(50) DEFAULT 'text',
  `module` VARCHAR(100) DEFAULT NULL,
  `options` TEXT DEFAULT NULL,
  `is_required` TINYINT DEFAULT 0,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 12. REMINDERS / EMAIL TEMPLATES
-- ================================================================

CREATE TABLE `reminders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `reminder_name` VARCHAR(255) NOT NULL,
  `subject_id` INT UNSIGNED DEFAULT NULL,
  `days_before` INT DEFAULT 0,
  `email_template_id` INT UNSIGNED DEFAULT NULL,
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `reminder_subjects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `subject_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `email_templates` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `template_name` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(500) DEFAULT NULL,
  `body` LONGTEXT DEFAULT NULL,
  `variables` TEXT DEFAULT NULL COMMENT 'Available merge variables',
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 13. CHARGES / SEALINGS
-- ================================================================

CREATE TABLE `register_charges` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `charge_number` VARCHAR(100) DEFAULT NULL,
  `charge_description` TEXT DEFAULT NULL,
  `charge_amount` DECIMAL(20,2) DEFAULT 0,
  `chargee_name` VARCHAR(255) DEFAULT NULL,
  `date_of_registration` DATE DEFAULT NULL,
  `date_of_discharge` DATE DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'Active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `sealings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `seal_date` DATE DEFAULT NULL,
  `document_description` TEXT DEFAULT NULL,
  `sealed_by` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ================================================================
-- 14. CRM: LEADS / QUOTATIONS / ORDERS / INVOICES
-- ================================================================

CREATE TABLE `leads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `lead_title` VARCHAR(500) DEFAULT NULL,
  `contact_name` VARCHAR(255) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `source_id` INT UNSIGNED DEFAULT NULL,
  `status_id` INT UNSIGNED DEFAULT NULL,
  `rating_id` INT UNSIGNED DEFAULT NULL,
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `expected_amount` DECIMAL(12,2) DEFAULT 0,
  `description` TEXT DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `lead_sources` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `source_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `lead_statuses` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `status_name` VARCHAR(100) NOT NULL,
  `color` VARCHAR(20) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `lead_ratings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `rating_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `followups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `lead_id` INT UNSIGNED DEFAULT NULL,
  `followup_mode_id` INT UNSIGNED DEFAULT NULL,
  `followup_agenda_id` INT UNSIGNED DEFAULT NULL,
  `followup_date` DATETIME DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `followup_modes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `mode_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `followup_agendas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `agenda_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `quotations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `lead_id` INT UNSIGNED DEFAULT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `quotation_number` VARCHAR(50) NOT NULL,
  `quotation_date` DATE DEFAULT NULL,
  `valid_until` DATE DEFAULT NULL,
  `total_amount` DECIMAL(12,2) DEFAULT 0,
  `tax_amount` DECIMAL(12,2) DEFAULT 0,
  `grand_total` DECIMAL(12,2) DEFAULT 0,
  `notes` TEXT DEFAULT NULL,
  `terms` TEXT DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Draft',
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `sales_orders` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `quotation_id` INT UNSIGNED DEFAULT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `order_number` VARCHAR(50) NOT NULL,
  `order_date` DATE DEFAULT NULL,
  `total_amount` DECIMAL(12,2) DEFAULT 0,
  `tax_amount` DECIMAL(12,2) DEFAULT 0,
  `grand_total` DECIMAL(12,2) DEFAULT 0,
  `notes` TEXT DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Pending',
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `invoices` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `order_id` INT UNSIGNED DEFAULT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `invoice_number` VARCHAR(50) NOT NULL,
  `invoice_date` DATE DEFAULT NULL,
  `due_date` DATE DEFAULT NULL,
  `subtotal` DECIMAL(12,2) DEFAULT 0,
  `tax_amount` DECIMAL(12,2) DEFAULT 0,
  `total` DECIMAL(12,2) DEFAULT 0,
  `amount_paid` DECIMAL(12,2) DEFAULT 0,
  `balance` DECIMAL(12,2) DEFAULT 0,
  `notes` TEXT DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Draft',
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `invoice_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `invoice_id` INT UNSIGNED NOT NULL,
  `fee_type_id` INT UNSIGNED DEFAULT NULL,
  `description` VARCHAR(500) DEFAULT NULL,
  `quantity` DECIMAL(10,2) DEFAULT 1,
  `unit_price` DECIMAL(12,2) DEFAULT 0,
  `amount` DECIMAL(12,2) DEFAULT 0,
  FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 15. PROJECTS / TASKS / ACTIVITIES / TIMESHEET
-- ================================================================

CREATE TABLE `projects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `project_name` VARCHAR(500) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `status_id` INT UNSIGNED DEFAULT NULL,
  `priority_id` INT UNSIGNED DEFAULT NULL,
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `budget` DECIMAL(12,2) DEFAULT 0,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `tasks` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED DEFAULT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `task_name` VARCHAR(500) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `task_type_id` INT UNSIGNED DEFAULT NULL,
  `task_group_id` INT UNSIGNED DEFAULT NULL,
  `priority_id` INT UNSIGNED DEFAULT NULL,
  `status_id` INT UNSIGNED DEFAULT NULL,
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `start_date` DATE DEFAULT NULL,
  `due_date` DATE DEFAULT NULL,
  `completed_date` DATE DEFAULT NULL,
  `estimated_hours` DECIMAL(8,2) DEFAULT 0,
  `actual_hours` DECIMAL(8,2) DEFAULT 0,
  `type` TINYINT DEFAULT 2 COMMENT '2=task, 3=ticket',
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `activities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `task_id` INT UNSIGNED DEFAULT NULL,
  `project_id` INT UNSIGNED DEFAULT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `activity_type` VARCHAR(50) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `activity_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `hours_spent` DECIMAL(8,2) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `timesheets` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `task_id` INT UNSIGNED DEFAULT NULL,
  `project_id` INT UNSIGNED DEFAULT NULL,
  `activity_id` INT UNSIGNED DEFAULT NULL,
  `date` DATE NOT NULL,
  `hours` DECIMAL(8,2) DEFAULT 0,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB;

-- PM Settings
CREATE TABLE `task_masters` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `task_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `cycle_masters` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `cycle_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `ticket_types` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `type_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `project_statuses` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `status_name` VARCHAR(100) NOT NULL,
  `color` VARCHAR(20) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `task_priorities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `priority_name` VARCHAR(100) NOT NULL,
  `color` VARCHAR(20) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `task_groups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `group_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `expense_heads` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `head_name` VARCHAR(255) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `task_checklists` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `checklist_name` VARCHAR(255) NOT NULL,
  `items` JSON DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 16. SUPPORT / TICKETS
-- ================================================================

CREATE TABLE `ticket_sources` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `source_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `ticket_priorities` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `priority_name` VARCHAR(100) NOT NULL,
  `color` VARCHAR(20) DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 17. TERMS & CONDITIONS / INVOICE SETTINGS
-- ================================================================

CREATE TABLE `terms_conditions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` LONGTEXT DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT 'general',
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `invoice_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `prefix` VARCHAR(20) DEFAULT 'INV',
  `next_number` INT DEFAULT 1,
  `tax_rate` DECIMAL(5,2) DEFAULT 0,
  `tax_name` VARCHAR(50) DEFAULT 'GST',
  `payment_terms` INT DEFAULT 30,
  `bank_details` TEXT DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- 18. TEAMS
-- ================================================================

CREATE TABLE `teams` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `team_name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `leader_id` INT UNSIGNED DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `team_members` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `team_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  FOREIGN KEY (`team_id`) REFERENCES `teams`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 19. UOM / BANK TRANSACTION APPROVERS
-- ================================================================

CREATE TABLE `uom_master` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `uom_name` VARCHAR(100) NOT NULL,
  `status` TINYINT DEFAULT 1,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `bank_transaction_approver_groups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `group_name` VARCHAR(255) NOT NULL,
  `approvers` JSON DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`)
) ENGINE=InnoDB;

-- ================================================================
-- SEED DATA
-- ================================================================

-- Default client
INSERT INTO `clients` (`client_id`, `company_name`) VALUES ('SG123', 'CorpFile');

-- Default admin user (password: Pass@123)
INSERT INTO `users` (`client_id`, `username`, `password`, `name`, `email`, `role`) VALUES (
  1, 'accountingtang', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'Accountingtang', 'admin@teamwork.sg', 'superadmin'
);

-- Default company types
INSERT INTO `company_types` (`client_id`, `type_name`) VALUES
(1, 'Exempt Private Company Limited by Shares'),
(1, 'Foreign Company registered in Singapore'),
(1, 'Limited Liability Partnership (LLP)'),
(1, 'Offshore'),
(1, 'Partnership'),
(1, 'Private Company Limited by Guarantee'),
(1, 'Private Company Limited by Shares'),
(1, 'Public Company Limited by Guarantee'),
(1, 'Public Company Limited By Shares'),
(1, 'Public Listed Company Limited by Shares'),
(1, 'Sole-Proprietorship'),
(1, 'Unlimited Exempt Private Company'),
(1, 'Unlimited Private Company'),
(1, 'Unlimited Public Company');

-- ─── Tickets ─────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS tickets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED,
    subject VARCHAR(255),
    description TEXT,
    status VARCHAR(50) DEFAULT 'Open',
    priority VARCHAR(50) DEFAULT 'Medium',
    type_id INT UNSIGNED,
    source_id INT UNSIGNED,
    assigned_to INT UNSIGNED,
    created_by INT UNSIGNED,
    company_id INT UNSIGNED,
    due_date DATE,
    closed_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ticket_conversations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT UNSIGNED,
    user_id INT UNSIGNED,
    message TEXT,
    attachment VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================================================================
-- 21. MODULES & PERMISSIONS
-- ================================================================

CREATE TABLE IF NOT EXISTS `modules` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `module_name` VARCHAR(100) NOT NULL,
  `module_slug` VARCHAR(100) DEFAULT NULL,
  `parent_id` INT UNSIGNED DEFAULT NULL,
  `sort_order` INT DEFAULT 0,
  `status` TINYINT DEFAULT 1
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `module_id` INT UNSIGNED NOT NULL,
  `can_view` TINYINT DEFAULT 0,
  `can_add` TINYINT DEFAULT 0,
  `can_edit` TINYINT DEFAULT 0,
  `can_delete` TINYINT DEFAULT 0,
  UNIQUE KEY `uk_user_module` (`user_id`, `module_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `group_permissions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `group_id` INT UNSIGNED NOT NULL,
  `module_id` INT UNSIGNED NOT NULL,
  `can_view` TINYINT DEFAULT 0,
  `can_add` TINYINT DEFAULT 0,
  `can_edit` TINYINT DEFAULT 0,
  `can_delete` TINYINT DEFAULT 0,
  UNIQUE KEY `uk_group_module` (`group_id`, `module_id`)
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
