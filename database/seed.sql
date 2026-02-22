-- ================================================================
-- Corporate Secretarial System - Demo Seed Data
-- Run AFTER schema.sql to populate with demo records
-- ================================================================

USE `corporate_secretary`;

SET FOREIGN_KEY_CHECKS = 0;

-- ================================================================
-- Additional Users
-- ================================================================
INSERT INTO `users` (`client_id`, `username`, `password`, `name`, `email`, `phone`, `role`) VALUES
(1, 'admin', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'System Admin', 'admin@yycs.sg', '91234567', 'admin'),
(1, 'sarah.lim', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'Sarah Lim', 'sarah@yycs.sg', '92345678', 'user'),
(1, 'david.tan', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'David Tan', 'david@yycs.sg', '93456789', 'user'),
(1, 'jenny.wong', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'Jenny Wong', 'jenny@yycs.sg', '94567890', 'user'),
(1, 'michael.chen', '$2y$12$oa82OqSB8iYGk4JPAyiAcuueCdio2cqOwqjTDbi95wRb8n3dOOtte', 'Michael Chen', 'michael@yycs.sg', '95678901', 'viewer');

-- ================================================================
-- User Groups
-- ================================================================
INSERT INTO `user_groups` (`client_id`, `group_name`, `description`) VALUES
(1, 'CSS Team', 'Corporate Secretarial Services team'),
(1, 'CRM Team', 'Customer Relationship Management team'),
(1, 'Accounts Team', 'Accounting and billing team'),
(1, 'Management', 'Senior management');

-- ================================================================
-- User Group Permissions
-- ================================================================
INSERT INTO `user_group_permissions` (`user_group_id`, `module`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES
(1, 'companies', 1, 1, 1, 1),
(1, 'members', 1, 1, 1, 1),
(1, 'officials', 1, 1, 1, 1),
(1, 'events', 1, 1, 1, 1),
(1, 'shares', 1, 1, 1, 0),
(1, 'documents', 1, 1, 1, 1),
(1, 'reports', 1, 0, 0, 0),
(2, 'crm', 1, 1, 1, 1),
(2, 'leads', 1, 1, 1, 1),
(2, 'quotations', 1, 1, 1, 0),
(2, 'invoices', 1, 1, 1, 0),
(2, 'projects', 1, 1, 1, 1),
(3, 'invoices', 1, 1, 1, 1),
(3, 'reports', 1, 0, 0, 0),
(4, 'companies', 1, 1, 1, 1),
(4, 'crm', 1, 1, 1, 1),
(4, 'settings', 1, 1, 1, 1),
(4, 'admin', 1, 1, 1, 1);

-- ================================================================
-- Members (Individuals)
-- ================================================================
INSERT INTO `members` (`client_id`, `name_initials`, `name`, `former_name`, `gender`, `date_of_birth`, `country_of_birth`, `nationality`, `race`, `status`, `email`, `mobile_code`, `mobile_number`, `business_occupation`, `created_by`) VALUES
(1, 'Mr', 'TAN AH KOW', NULL, 'Male', '1975-03-15', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'ahkow.tan@email.com', '65', '91234567', 'Business Consultant', 1),
(1, 'Ms', 'LIM MEI LING', NULL, 'Female', '1980-07-22', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'meiling.lim@email.com', '65', '92345678', 'Accountant', 1),
(1, 'Mr', 'KUMAR S/O RAJAN', NULL, 'Male', '1978-11-05', 'SINGAPORE', 'SINGAPOREAN', 'Indian', 'Active', 'kumar.rajan@email.com', '65', '93456789', 'Engineer', 1),
(1, 'Mrs', 'WONG PEI FANG', 'CHEN PEI FANG', 'Female', '1982-01-30', 'MALAYSIA', 'MALAYSIAN', 'Chinese', 'Active', 'peifang.wong@email.com', '65', '94567890', 'Director', 1),
(1, 'Mr', 'DAVID LEE WEI MING', NULL, 'Male', '1970-06-18', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'david.lee@email.com', '65', '95678901', 'Managing Director', 1),
(1, 'Mr', 'JOHN SMITH', NULL, 'Male', '1985-09-12', 'UNITED KINGDOM', 'BRITISH', NULL, 'Active', 'john.smith@email.com', '65', '96789012', 'Investment Manager', 1),
(1, 'Ms', 'SARAH TAN MEI HUI', NULL, 'Female', '1990-04-25', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'sarah.tan@email.com', '65', '97890123', 'Company Secretary', 1),
(1, 'Mr', 'AHMAD BIN HASSAN', NULL, 'Male', '1972-12-08', 'SINGAPORE', 'SINGAPOREAN', 'Malay', 'Active', 'ahmad.hassan@email.com', '65', '98901234', 'Business Owner', 1),
(1, 'Dr', 'CHEN XIAO MING', NULL, 'Male', '1968-02-14', 'CHINA', 'CHINESE', 'Chinese', 'Active', 'xiaoming.chen@email.com', '65', '99012345', 'Medical Doctor', 1),
(1, 'Ms', 'RACHEL GOH SHU TING', NULL, 'Female', '1988-08-03', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'rachel.goh@email.com', '65', '90123456', 'Auditor', 1),
(1, 'Mr', 'MICHAEL ANG WEI JIE', NULL, 'Male', '1979-05-20', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Deceased', 'michael.ang@email.com', '65', '91234568', 'Former Director', 1),
(1, 'Mr', 'PETER CHUA BENG HUAT', NULL, 'Male', '1965-10-11', 'SINGAPORE', 'SINGAPOREAN', 'Chinese', 'Active', 'peter.chua@email.com', '65', '92345679', 'Retired', 1);

-- ================================================================
-- Member Identifications
-- ================================================================
INSERT INTO `member_identifications` (`member_id`, `id_type`, `id_number`, `country`, `issued_date`, `expired_date`) VALUES
(1, 'NRIC', 'S7515123A', 'SINGAPORE', '1991-03-15', NULL),
(2, 'NRIC', 'S8022456B', 'SINGAPORE', '1996-07-22', NULL),
(3, 'NRIC', 'S7811789C', 'SINGAPORE', '1994-11-05', NULL),
(4, 'Passport', 'A12345678', 'MALAYSIA', '2020-01-30', '2030-01-29'),
(5, 'NRIC', 'S7006234D', 'SINGAPORE', '1986-06-18', NULL),
(6, 'Passport', 'GB9876543', 'UNITED KINGDOM', '2019-09-12', '2029-09-11'),
(7, 'NRIC', 'S9004567E', 'SINGAPORE', '2006-04-25', NULL),
(8, 'NRIC', 'S7212890F', 'SINGAPORE', '1988-12-08', NULL),
(9, 'FIN', 'F6802345G', 'SINGAPORE', '2018-02-14', '2028-02-13'),
(10, 'NRIC', 'S8808901H', 'SINGAPORE', '2004-08-03', NULL),
(11, 'NRIC', 'S7905678I', 'SINGAPORE', '1995-05-20', NULL),
(12, 'NRIC', 'S6510234J', 'SINGAPORE', '1981-10-11', NULL);

-- ================================================================
-- Addresses for Members
-- ================================================================
INSERT INTO `addresses` (`entity_type`, `entity_id`, `address_type`, `is_default`, `block`, `address_text`, `level`, `unit`, `country`, `postal_code`) VALUES
('member', 1, 'Local Residential', 1, '123', 'Ang Mo Kio Ave 6', '05', '123', 'SINGAPORE', '560123'),
('member', 2, 'Local Residential', 1, '456', 'Bedok North Road', '12', '456', 'SINGAPORE', '460456'),
('member', 3, 'Local Residential', 1, '789', 'Clementi Ave 3', '08', '789', 'SINGAPORE', '120789'),
('member', 4, 'Local Residential', 1, '321', 'Tampines Street 21', '03', '321', 'SINGAPORE', '520321'),
('member', 4, 'Foreign Residential', 0, NULL, '88 Jalan Bukit Bintang', NULL, NULL, 'MALAYSIA', '55100'),
('member', 5, 'Local Residential', 1, '654', 'Bukit Timah Road', '10', '654', 'SINGAPORE', '269654'),
('member', 6, 'Local Residential', 1, NULL, '1 Raffles Place #20-01', NULL, NULL, 'SINGAPORE', '048616'),
('member', 6, 'Foreign Residential', 0, NULL, '45 Oxford Street', NULL, NULL, 'UNITED KINGDOM', 'W1D 2DZ'),
('member', 7, 'Local Residential', 1, '987', 'Jurong West Street 42', '15', '987', 'SINGAPORE', '640987'),
('member', 8, 'Local Residential', 1, '111', 'Woodlands Drive 14', '07', '111', 'SINGAPORE', '730111'),
('member', 9, 'Local Residential', 1, NULL, '8 Shenton Way #25-01', NULL, NULL, 'SINGAPORE', '068811'),
('member', 10, 'Local Residential', 1, '222', 'Pasir Ris Street 11', '04', '222', 'SINGAPORE', '510222');

-- ================================================================
-- Companies
-- ================================================================
INSERT INTO `companies` (`client_id`, `company_name`, `former_name`, `trading_name`, `company_id_code`, `company_type_id`, `registration_number`, `acra_registration_number`, `country`, `incorporation_date`, `entity_status`, `internal_css_status`, `risk_assessment_rating`, `common_seal`, `activity_1`, `activity_1_desc_default`, `ord_issued_share_capital`, `ord_currency`, `no_ord_shares`, `paid_up_capital`, `paid_up_capital_currency`, `fye_date`, `next_agm_due`, `date_of_agm`, `date_of_ar`, `contact_person`, `phone1_code`, `phone1_number`, `email`, `website`, `is_css_client`, `is_client`, `created_by`) VALUES
(1, 'ABC HOLDINGS PTE. LTD.', NULL, 'ABC Holdings', 'C001', 7, '201512345A', '201512345A', 'SINGAPORE', '2015-06-15', 'Live', 'Active', 'Low', 'Yes', '64200', 'Holding companies', 1000000.00, 'SGD', 1000000, 1000000.00, 'SGD', '2025-12-31', '2026-06-30', '2025-04-15', '2025-05-30', 'TAN AH KOW', '65', '61234567', 'info@abcholdings.sg', 'www.abcholdings.sg', 1, 1, 1),
(1, 'XYZ TRADING PTE. LTD.', NULL, 'XYZ Trading', 'C002', 7, '201812345B', '201812345B', 'SINGAPORE', '2018-03-20', 'Live', 'Active', 'Low', 'No', '46100', 'Wholesale of a variety of goods', 500000.00, 'SGD', 500000, 500000.00, 'SGD', '2025-12-31', '2026-06-30', '2025-03-28', '2025-05-15', 'LIM MEI LING', '65', '62345678', 'info@xyztrading.sg', NULL, 1, 1, 1),
(1, 'GLOBAL TECH SOLUTIONS PTE. LTD.', 'GLOBAL TECH PTE. LTD.', 'Global Tech', 'C003', 1, '202012345C', '202012345C', 'SINGAPORE', '2020-01-10', 'Live', 'Active', 'Medium', 'Yes', '62011', 'Computer programming activities', 100000.00, 'SGD', 100000, 100000.00, 'SGD', '2025-12-31', '2026-04-10', NULL, NULL, 'KUMAR S/O RAJAN', '65', '63456789', 'hello@globaltech.sg', 'www.globaltech.sg', 1, 1, 1),
(1, 'SUNRISE F&B PTE. LTD.', NULL, 'Sunrise Cafe', 'C004', 1, '201912345D', '201912345D', 'SINGAPORE', '2019-08-01', 'Live', 'Active', 'Low', 'No', '56101', 'Restaurants', 200000.00, 'SGD', 200000, 200000.00, 'SGD', '2025-07-31', '2026-01-31', '2025-01-20', '2025-03-15', 'WONG PEI FANG', '65', '64567890', 'contact@sunrisecafe.sg', 'www.sunrisecafe.sg', 1, 1, 1),
(1, 'PINNACLE INVESTMENTS PTE. LTD.', NULL, 'Pinnacle Investments', 'C005', 7, '201712345E', '201712345E', 'SINGAPORE', '2017-11-25', 'Live', 'Active', 'High', 'Yes', '64910', 'Financial service activities', 5000000.00, 'SGD', 5000000, 5000000.00, 'SGD', '2025-12-31', '2026-06-30', '2025-04-10', '2025-06-01', 'DAVID LEE WEI MING', '65', '65678901', 'invest@pinnacle.sg', 'www.pinnacle.sg', 1, 1, 1),
(1, 'OCEANIC SHIPPING PTE. LTD.', NULL, NULL, 'C006', 7, '201612345F', '201612345F', 'SINGAPORE', '2016-04-12', 'Live', 'Active', 'Medium', 'Yes', '50111', 'Sea transport of passengers', 2000000.00, 'SGD', 2000000, 2000000.00, 'SGD', '2025-03-31', '2025-09-30', '2025-09-10', '2025-10-15', 'JOHN SMITH', '65', '66789012', 'ops@oceanicshipping.sg', NULL, 1, 1, 1),
(1, 'GREEN ENERGY SOLUTIONS PTE. LTD.', NULL, 'GreenE', 'C007', 1, '202112345G', '202112345G', 'SINGAPORE', '2021-02-28', 'Live', 'Active', 'Low', 'No', '35111', 'Electric power generation', 300000.00, 'SGD', 300000, 300000.00, 'SGD', '2025-12-31', '2026-06-28', NULL, NULL, 'SARAH TAN MEI HUI', '65', '67890123', 'info@greene.sg', 'www.greene.sg', 1, 1, 1),
(1, 'HERITAGE PROPERTY PTE. LTD.', NULL, 'Heritage', 'C008', 7, '201412345H', '201412345H', 'SINGAPORE', '2014-09-08', 'Live', 'Active', 'Low', 'Yes', '68100', 'Real estate activities', 10000000.00, 'SGD', 10000000, 10000000.00, 'SGD', '2025-08-31', '2026-02-28', '2025-02-15', '2025-04-01', 'AHMAD BIN HASSAN', '65', '68901234', 'enquiry@heritage.sg', 'www.heritage.sg', 1, 1, 1),
(1, 'MEDCARE CLINICS PTE. LTD.', NULL, 'MedCare', 'C009', 1, '202212345I', '202212345I', 'SINGAPORE', '2022-05-15', 'Live', 'Active', 'Low', 'No', '86101', 'General medical services', 500000.00, 'SGD', 500000, 500000.00, 'SGD', '2025-12-31', '2026-11-15', NULL, NULL, 'CHEN XIAO MING', '65', '69012345', 'clinic@medcare.sg', 'www.medcare.sg', 1, 1, 1),
(1, 'INFINITY CONSULTING PTE. LTD.', NULL, 'Infinity', 'C010', 1, '202312345J', '202312345J', 'SINGAPORE', '2023-01-03', 'Live', 'Pre-Incorporation', 'Low', 'No', '70201', 'Management consultancy', 10000.00, 'SGD', 10000, 10000.00, 'SGD', '2025-12-31', '2027-07-03', NULL, NULL, 'RACHEL GOH SHU TING', '65', '60123456', 'hello@infinity.sg', NULL, 1, 1, 1),
(1, 'ALPHA LOGISTICS PTE. LTD.', NULL, NULL, 'C011', 7, '201312345K', '201312345K', 'SINGAPORE', '2013-07-22', 'Struck Off', 'Terminated', 'Low', 'No', '52101', 'Warehousing', 100000.00, 'SGD', 100000, 100000.00, 'SGD', '2022-06-30', NULL, '2022-06-15', '2022-08-01', 'PETER CHUA BENG HUAT', '65', '61234569', NULL, NULL, 1, 1, 1),
(1, 'BETA CONSTRUCTION PTE. LTD.', NULL, 'Beta Build', 'C012', 7, '201112345L', '201112345L', 'SINGAPORE', '2011-11-11', 'Live', 'Active', 'Medium', 'Yes', '41001', 'Building construction', 3000000.00, 'SGD', 3000000, 3000000.00, 'SGD', '2025-10-31', '2026-04-30', '2025-04-01', '2025-05-30', 'TAN AH KOW', '65', '62345680', 'projects@betabuild.sg', 'www.betabuild.sg', 1, 1, 1),
-- Pre-incorporation / Non-client companies
(1, 'FUTURE VENTURES PTE. LTD.', NULL, NULL, 'C013', 7, NULL, NULL, 'SINGAPORE', NULL, NULL, 'Pre-Incorporation', 'Low', NULL, NULL, NULL, 1.00, 'SGD', 1, 1.00, 'SGD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1),
(1, 'OMEGA PARTNERS LLP', NULL, NULL, 'C014', 3, '201812346Z', 'T18LL1234Z', 'SINGAPORE', '2018-06-30', 'Live', 'Active', 'Low', 'No', '69201', 'Accounting services', 0.00, 'SGD', 0, 0.00, 'SGD', '2025-06-30', '2026-01-31', '2025-01-10', '2025-02-28', 'LIM MEI LING', '65', '63456790', 'info@omega.sg', NULL, 1, 1, 1),
(1, 'DELTA MARKETING SERVICES', NULL, NULL, 'C015', 11, '53123456A', '53123456A', 'SINGAPORE', '2020-03-01', 'Live', 'Active', 'Low', 'No', '73110', 'Advertising', 0.00, 'SGD', 0, 0.00, 'SGD', NULL, NULL, NULL, NULL, 'WONG PEI FANG', '65', '64567891', NULL, NULL, 0, 0, 1);

-- ================================================================
-- Addresses for Companies
-- ================================================================
INSERT INTO `addresses` (`entity_type`, `entity_id`, `address_type`, `is_default`, `block`, `address_text`, `building`, `level`, `unit`, `country`, `postal_code`) VALUES
('company', 1, 'Registered Office', 1, NULL, '1 Raffles Place', 'ONE RAFFLES PLACE', '20', '01', 'SINGAPORE', '048616'),
('company', 2, 'Registered Office', 1, NULL, '10 Anson Road', 'INTERNATIONAL PLAZA', '15', '05', 'SINGAPORE', '079903'),
('company', 3, 'Registered Office', 1, NULL, '1 Fusionopolis Walk', 'SOLARIS', '10', '01', 'SINGAPORE', '138628'),
('company', 4, 'Registered Office', 1, '123', 'Orchard Road', 'LUCKY PLAZA', '01', '23', 'SINGAPORE', '238863'),
('company', 5, 'Registered Office', 1, NULL, '8 Marina View', 'ASIA SQUARE TOWER 1', '35', '01', 'SINGAPORE', '018960'),
('company', 6, 'Registered Office', 1, NULL, '1 Harbourfront Avenue', 'KEPPEL BAY TOWER', '08', '12', 'SINGAPORE', '098632'),
('company', 7, 'Registered Office', 1, NULL, '21 Cleantech Loop', 'CLEANTECH TWO', '05', '08', 'SINGAPORE', '636732'),
('company', 8, 'Registered Office', 1, NULL, '80 Robinson Road', 'ROBINSON 77', '12', '01', 'SINGAPORE', '068898'),
('company', 9, 'Registered Office', 1, NULL, '3 Mount Elizabeth', 'MOUNT ELIZABETH MEDICAL CENTRE', '02', '05', 'SINGAPORE', '228510'),
('company', 10, 'Registered Office', 1, NULL, '77 Robinson Road', 'ROBINSON 77', '15', '02', 'SINGAPORE', '068896'),
('company', 11, 'Registered Office', 1, NULL, '51 Changi South Avenue 2', NULL, NULL, NULL, 'SINGAPORE', '486133'),
('company', 12, 'Registered Office', 1, NULL, '5 Toh Tuck Link', NULL, '03', '12', 'SINGAPORE', '596224');

-- ================================================================
-- Directors
-- ================================================================
INSERT INTO `directors` (`company_id`, `member_id`, `role`, `name`, `id_type`, `id_number`, `nationality`, `email`, `date_of_birth`, `date_of_appointment`, `status`) VALUES
(1, 1, 'director', 'TAN AH KOW', 'NRIC', 'S7515123A', 'SINGAPOREAN', 'ahkow.tan@email.com', '1975-03-15', '2015-06-15', 'Active'),
(1, 5, 'director', 'DAVID LEE WEI MING', 'NRIC', 'S7006234D', 'SINGAPOREAN', 'david.lee@email.com', '1970-06-18', '2015-06-15', 'Active'),
(2, 2, 'director', 'LIM MEI LING', 'NRIC', 'S8022456B', 'SINGAPOREAN', 'meiling.lim@email.com', '1980-07-22', '2018-03-20', 'Active'),
(2, 1, 'director', 'TAN AH KOW', 'NRIC', 'S7515123A', 'SINGAPOREAN', 'ahkow.tan@email.com', '1975-03-15', '2019-01-15', 'Active'),
(3, 3, 'director', 'KUMAR S/O RAJAN', 'NRIC', 'S7811789C', 'SINGAPOREAN', 'kumar.rajan@email.com', '1978-11-05', '2020-01-10', 'Active'),
(4, 4, 'director', 'WONG PEI FANG', 'Passport', 'A12345678', 'MALAYSIAN', 'peifang.wong@email.com', '1982-01-30', '2019-08-01', 'Active'),
(4, 8, 'director', 'AHMAD BIN HASSAN', 'NRIC', 'S7212890F', 'SINGAPOREAN', 'ahmad.hassan@email.com', '1972-12-08', '2019-08-01', 'Active'),
(5, 5, 'director', 'DAVID LEE WEI MING', 'NRIC', 'S7006234D', 'SINGAPOREAN', 'david.lee@email.com', '1970-06-18', '2017-11-25', 'Active'),
(5, 6, 'director', 'JOHN SMITH', 'Passport', 'GB9876543', 'BRITISH', 'john.smith@email.com', '1985-09-12', '2018-06-01', 'Active'),
(6, 6, 'director', 'JOHN SMITH', 'Passport', 'GB9876543', 'BRITISH', 'john.smith@email.com', '1985-09-12', '2016-04-12', 'Active'),
(7, 7, 'director', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '1990-04-25', '2021-02-28', 'Active'),
(8, 8, 'director', 'AHMAD BIN HASSAN', 'NRIC', 'S7212890F', 'SINGAPOREAN', 'ahmad.hassan@email.com', '1972-12-08', '2014-09-08', 'Active'),
(8, 12, 'director', 'PETER CHUA BENG HUAT', 'NRIC', 'S6510234J', 'SINGAPOREAN', 'peter.chua@email.com', '1965-10-11', '2014-09-08', 'Active'),
(9, 9, 'director', 'CHEN XIAO MING', 'FIN', 'F6802345G', 'CHINESE', 'xiaoming.chen@email.com', '1968-02-14', '2022-05-15', 'Active'),
(10, 10, 'director', 'RACHEL GOH SHU TING', 'NRIC', 'S8808901H', 'SINGAPOREAN', 'rachel.goh@email.com', '1988-08-03', '2023-01-03', 'Active'),
(11, 12, 'director', 'PETER CHUA BENG HUAT', 'NRIC', 'S6510234J', 'SINGAPOREAN', 'peter.chua@email.com', '1965-10-11', '2013-07-22', 'Ceased'),
(12, 1, 'director', 'TAN AH KOW', 'NRIC', 'S7515123A', 'SINGAPOREAN', 'ahkow.tan@email.com', '1975-03-15', '2011-11-11', 'Active');

-- ================================================================
-- Shareholders
-- ================================================================
INSERT INTO `shareholders` (`company_id`, `member_id`, `shareholder_type`, `name`, `id_type`, `id_number`, `nationality`, `email`, `date_of_birth`, `date_of_appointment`, `status`) VALUES
(1, 1, 'Individual', 'TAN AH KOW', 'NRIC', 'S7515123A', 'SINGAPOREAN', 'ahkow.tan@email.com', '1975-03-15', '2015-06-15', 'Active'),
(1, 5, 'Individual', 'DAVID LEE WEI MING', 'NRIC', 'S7006234D', 'SINGAPOREAN', 'david.lee@email.com', '1970-06-18', '2015-06-15', 'Active'),
(2, 2, 'Individual', 'LIM MEI LING', 'NRIC', 'S8022456B', 'SINGAPOREAN', 'meiling.lim@email.com', '1980-07-22', '2018-03-20', 'Active'),
(3, 3, 'Individual', 'KUMAR S/O RAJAN', 'NRIC', 'S7811789C', 'SINGAPOREAN', 'kumar.rajan@email.com', '1978-11-05', '2020-01-10', 'Active'),
(4, 4, 'Individual', 'WONG PEI FANG', 'Passport', 'A12345678', 'MALAYSIAN', 'peifang.wong@email.com', '1982-01-30', '2019-08-01', 'Active'),
(4, 8, 'Individual', 'AHMAD BIN HASSAN', 'NRIC', 'S7212890F', 'SINGAPOREAN', 'ahmad.hassan@email.com', '1972-12-08', '2019-08-01', 'Active'),
(5, 5, 'Individual', 'DAVID LEE WEI MING', 'NRIC', 'S7006234D', 'SINGAPOREAN', 'david.lee@email.com', '1970-06-18', '2017-11-25', 'Active'),
(5, 6, 'Individual', 'JOHN SMITH', 'Passport', 'GB9876543', 'BRITISH', 'john.smith@email.com', '1985-09-12', '2018-06-01', 'Active'),
(6, 6, 'Individual', 'JOHN SMITH', 'Passport', 'GB9876543', 'BRITISH', 'john.smith@email.com', '1985-09-12', '2016-04-12', 'Active'),
(7, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '1990-04-25', '2021-02-28', 'Active'),
(8, 8, 'Individual', 'AHMAD BIN HASSAN', 'NRIC', 'S7212890F', 'SINGAPOREAN', 'ahmad.hassan@email.com', '1972-12-08', '2014-09-08', 'Active'),
(9, 9, 'Individual', 'CHEN XIAO MING', 'FIN', 'F6802345G', 'CHINESE', 'xiaoming.chen@email.com', '1968-02-14', '2022-05-15', 'Active'),
(10, 10, 'Individual', 'RACHEL GOH SHU TING', 'NRIC', 'S8808901H', 'SINGAPOREAN', 'rachel.goh@email.com', '1988-08-03', '2023-01-03', 'Active'),
(12, 1, 'Individual', 'TAN AH KOW', 'NRIC', 'S7515123A', 'SINGAPOREAN', 'ahkow.tan@email.com', '1975-03-15', '2011-11-11', 'Active');

-- ================================================================
-- Secretaries
-- ================================================================
INSERT INTO `secretaries` (`company_id`, `member_id`, `secretary_type`, `name`, `id_type`, `id_number`, `nationality`, `email`, `date_of_appointment`, `status`) VALUES
(1, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2015-06-15', 'Active'),
(2, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2018-03-20', 'Active'),
(3, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2020-01-10', 'Active'),
(4, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2019-08-01', 'Active'),
(5, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2017-11-25', 'Active'),
(6, 2, 'Individual', 'LIM MEI LING', 'NRIC', 'S8022456B', 'SINGAPOREAN', 'meiling.lim@email.com', '2016-04-12', 'Active'),
(7, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2021-02-28', 'Active'),
(8, 2, 'Individual', 'LIM MEI LING', 'NRIC', 'S8022456B', 'SINGAPOREAN', 'meiling.lim@email.com', '2014-09-08', 'Active'),
(9, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2022-05-15', 'Active'),
(10, 7, 'Individual', 'SARAH TAN MEI HUI', 'NRIC', 'S9004567E', 'SINGAPOREAN', 'sarah.tan@email.com', '2023-01-03', 'Active'),
(12, 2, 'Individual', 'LIM MEI LING', 'NRIC', 'S8022456B', 'SINGAPOREAN', 'meiling.lim@email.com', '2011-11-11', 'Active');

-- ================================================================
-- Auditors
-- ================================================================
INSERT INTO `auditors` (`company_id`, `name`, `firm_name`, `registration_number`, `address`, `date_of_appointment`, `status`) VALUES
(1, 'KPMG LLP', 'KPMG LLP', 'T08LL1267E', '16 Raffles Quay #22-00 Hong Leong Building Singapore 048581', '2015-06-15', 'Active'),
(2, 'Baker Tilly TFW LLP', 'Baker Tilly TFW LLP', 'T08LL1520F', '600 North Bridge Road #05-01 Parkview Square Singapore 188778', '2018-03-20', 'Active'),
(5, 'Ernst & Young LLP', 'Ernst & Young LLP', 'T08LL1001A', 'One Raffles Quay North Tower Level 18 Singapore 048583', '2017-11-25', 'Active'),
(6, 'Deloitte & Touche LLP', 'Deloitte & Touche LLP', 'T08LL0721A', '6 Shenton Way #33-00 OUE Downtown 2 Singapore 068809', '2016-04-12', 'Active'),
(8, 'PricewaterhouseCoopers LLP', 'PricewaterhouseCoopers LLP', 'T09LL0001A', '7 Straits View Marina One East Tower Level 12 Singapore 018936', '2014-09-08', 'Active'),
(12, 'Baker Tilly TFW LLP', 'Baker Tilly TFW LLP', 'T08LL1520F', '600 North Bridge Road #05-01 Parkview Square Singapore 188778', '2011-11-11', 'Active');

-- ================================================================
-- Share Transactions
-- ================================================================
INSERT INTO `company_shares` (`company_id`, `shareholder_id`, `currency`, `share_type`, `type`, `number_of_shares`, `issued_share_capital`, `paid_up_capital`, `transaction_date`) VALUES
(1, 1, 'SGD', 'Ordinary', 'Allotment', 600000, 600000.00, 600000.00, '2015-06-15'),
(1, 2, 'SGD', 'Ordinary', 'Allotment', 400000, 400000.00, 400000.00, '2015-06-15'),
(2, 3, 'SGD', 'Ordinary', 'Allotment', 500000, 500000.00, 500000.00, '2018-03-20'),
(3, 4, 'SGD', 'Ordinary', 'Allotment', 100000, 100000.00, 100000.00, '2020-01-10'),
(4, 5, 'SGD', 'Ordinary', 'Allotment', 120000, 120000.00, 120000.00, '2019-08-01'),
(4, 6, 'SGD', 'Ordinary', 'Allotment', 80000, 80000.00, 80000.00, '2019-08-01'),
(5, 7, 'SGD', 'Ordinary', 'Allotment', 3000000, 3000000.00, 3000000.00, '2017-11-25'),
(5, 8, 'SGD', 'Ordinary', 'Allotment', 2000000, 2000000.00, 2000000.00, '2018-06-01'),
(7, 10, 'SGD', 'Ordinary', 'Allotment', 300000, 300000.00, 300000.00, '2021-02-28'),
(8, 11, 'SGD', 'Ordinary', 'Allotment', 10000000, 10000000.00, 10000000.00, '2014-09-08');

-- ================================================================
-- Company Events (AGM / AR / FYE)
-- ================================================================
INSERT INTO `company_events` (`company_id`, `event_type`, `fye_year`, `fye_date`, `fye_month`, `agm_due_date`, `agm_held_date`, `ar_due_date`, `ar_filing_date`, `status`) VALUES
-- ABC Holdings AGM history
(1, 'AGM', '2023', '2023-12-31', 'December', '2024-06-30', '2024-04-20', '2024-07-30', '2024-05-15', 'Completed'),
(1, 'AGM', '2024', '2024-12-31', 'December', '2025-06-30', '2025-04-15', '2025-07-30', '2025-05-30', 'Completed'),
(1, 'AGM', '2025', '2025-12-31', 'December', '2026-06-30', NULL, '2026-07-30', NULL, 'Pending'),
-- XYZ Trading
(2, 'AGM', '2023', '2023-12-31', 'December', '2024-06-30', '2024-03-25', '2024-07-30', '2024-05-10', 'Completed'),
(2, 'AGM', '2024', '2024-12-31', 'December', '2025-06-30', '2025-03-28', '2025-07-30', '2025-05-15', 'Completed'),
(2, 'AGM', '2025', '2025-12-31', 'December', '2026-06-30', NULL, '2026-07-30', NULL, 'Pending'),
-- Global Tech
(3, 'AGM', '2024', '2024-12-31', 'December', '2025-04-10', NULL, '2025-05-10', NULL, 'Pending'),
-- Sunrise F&B
(4, 'AGM', '2024', '2024-07-31', 'July', '2025-01-31', '2025-01-20', '2025-02-28', '2025-03-15', 'Completed'),
(4, 'AGM', '2025', '2025-07-31', 'July', '2026-01-31', NULL, '2026-02-28', NULL, 'Pending'),
-- Pinnacle Investments
(5, 'AGM', '2024', '2024-12-31', 'December', '2025-06-30', '2025-04-10', '2025-07-30', '2025-06-01', 'Completed'),
(5, 'AGM', '2025', '2025-12-31', 'December', '2026-06-30', NULL, '2026-07-30', NULL, 'Pending'),
-- Oceanic Shipping
(6, 'AGM', '2024', '2024-03-31', 'March', '2024-09-30', '2024-09-15', '2024-10-30', '2024-10-20', 'Completed'),
(6, 'AGM', '2025', '2025-03-31', 'March', '2025-09-30', NULL, '2025-10-30', NULL, 'Pending'),
-- Heritage Property
(8, 'AGM', '2024', '2024-08-31', 'August', '2025-02-28', '2025-02-15', '2025-03-31', '2025-04-01', 'Completed'),
(8, 'AGM', '2025', '2025-08-31', 'August', '2026-02-28', NULL, '2026-03-31', NULL, 'Pending'),
-- Beta Construction
(12, 'AGM', '2024', '2024-10-31', 'October', '2025-04-30', '2025-04-01', '2025-05-30', '2025-05-30', 'Completed'),
(12, 'AGM', '2025', '2025-10-31', 'October', '2026-04-30', NULL, '2026-05-30', NULL, 'Pending');

-- ================================================================
-- Settings - Master Lists
-- ================================================================

-- Regions
INSERT INTO `regions` (`client_id`, `region_name`) VALUES
(1, 'Singapore'), (1, 'Malaysia'), (1, 'China'), (1, 'Hong Kong'), (1, 'BVI'), (1, 'Cayman Islands');

-- Banks
INSERT INTO `banks` (`client_id`, `bank_name`, `bank_code`, `swift_code`) VALUES
(1, 'DBS Bank', '7171', 'DBSSSGSG'),
(1, 'OCBC Bank', '7339', 'OCBCSGSG'),
(1, 'UOB', '7375', 'UOVBSGSG'),
(1, 'Standard Chartered Bank', '9496', 'SCBLSGSG'),
(1, 'HSBC', '7232', 'HSBCSGSG'),
(1, 'Citibank', '7214', 'CITISGSG'),
(1, 'Maybank', '7302', 'MBBESGSG');

-- Industries
INSERT INTO `industries` (`client_id`, `industry_name`) VALUES
(1, 'Information Technology'), (1, 'Financial Services'), (1, 'Manufacturing'),
(1, 'Real Estate'), (1, 'Healthcare'), (1, 'Food & Beverage'),
(1, 'Shipping & Logistics'), (1, 'Construction'), (1, 'Energy'),
(1, 'Consulting'), (1, 'Education'), (1, 'Retail');

-- Market Segments
INSERT INTO `market_segments` (`client_id`, `segment_name`) VALUES
(1, 'SME'), (1, 'MNC'), (1, 'Start-up'), (1, 'Listed Company'), (1, 'Government-linked');

-- Account Types
INSERT INTO `account_types` (`client_id`, `type_name`) VALUES
(1, 'Current Account'), (1, 'Savings Account'), (1, 'Fixed Deposit'), (1, 'Multi-Currency Account');

-- Payment Modes
INSERT INTO `payment_modes` (`client_id`, `mode_name`) VALUES
(1, 'Bank Transfer'), (1, 'Cheque'), (1, 'Cash'), (1, 'PayNow'), (1, 'Credit Card'), (1, 'GIRO');

-- Fee Types
INSERT INTO `fee_types` (`client_id`, `fee_name`, `amount`, `currency`, `description`) VALUES
(1, 'Annual Return Filing Fee', 60.00, 'SGD', 'ACRA filing fee for Annual Return'),
(1, 'Company Secretary Fee (Annual)', 1200.00, 'SGD', 'Annual company secretarial service fee'),
(1, 'Director Appointment Fee', 300.00, 'SGD', 'Filing fee for appointment of director'),
(1, 'Share Allotment Fee', 350.00, 'SGD', 'Filing fee for allotment of shares'),
(1, 'Registered Address Fee', 600.00, 'SGD', 'Annual registered address service fee'),
(1, 'Company Incorporation Fee', 1500.00, 'SGD', 'Fee for incorporation of new company'),
(1, 'GST Registration Fee', 500.00, 'SGD', 'Filing fee for GST registration'),
(1, 'Change of Company Name', 150.00, 'SGD', 'ACRA fee for change of company name');

-- Member ID Types
INSERT INTO `member_id_types` (`client_id`, `type_name`) VALUES
(1, 'NRIC'), (1, 'Passport'), (1, 'FIN'), (1, 'Driving License'), (1, 'Birth Certificate');

-- Event Types
INSERT INTO `event_types` (`client_id`, `event_name`, `is_recurring`, `recurring_interval`) VALUES
(1, 'Annual General Meeting', 1, 12),
(1, 'Annual Return Filing', 1, 12),
(1, 'Financial Year End', 1, 12),
(1, 'Anniversary', 1, 12),
(1, 'Director Resolution', 0, NULL),
(1, 'Shareholder Resolution', 0, NULL),
(1, 'Board Meeting', 0, NULL),
(1, 'ID Expiry', 0, NULL);

-- Share Classes
INSERT INTO `share_classes` (`client_id`, `class_name`, `description`) VALUES
(1, 'Ordinary', 'Ordinary shares with full voting rights'),
(1, 'Preference', 'Preference shares with fixed dividend'),
(1, 'Redeemable Preference', 'Redeemable preference shares');

-- Document Categories
INSERT INTO `document_categories` (`client_id`, `category_name`) VALUES
(1, 'Incorporation Documents'),
(1, 'Board Resolutions'),
(1, 'Shareholder Resolutions'),
(1, 'Financial Statements'),
(1, 'Annual Returns'),
(1, 'Share Certificates'),
(1, 'Constitution'),
(1, 'Agreements'),
(1, 'KYC Documents'),
(1, 'Tax Documents');

-- Designations
INSERT INTO `designations` (`client_id`, `designation_name`) VALUES
(1, 'Managing Director'), (1, 'Executive Director'), (1, 'Non-Executive Director'),
(1, 'Independent Director'), (1, 'Alternate Director'), (1, 'Company Secretary'),
(1, 'Chief Executive Officer'), (1, 'Chief Financial Officer'), (1, 'Chief Operating Officer');

-- Tags
INSERT INTO `tags` (`client_id`, `tag_name`, `tag_type`) VALUES
(1, 'VIP Client', 'company'), (1, 'Priority', 'company'), (1, 'Dormant', 'company'),
(1, 'New Client', 'company'), (1, 'High Value', 'company'), (1, 'Review Pending', 'company');

-- Status Master
INSERT INTO `status_master` (`client_id`, `status_name`, `status_type`, `color`) VALUES
(1, 'Active', 'general', '#28a745'),
(1, 'Pending', 'general', '#ffc107'),
(1, 'Completed', 'general', '#007bff'),
(1, 'Cancelled', 'general', '#dc3545'),
(1, 'On Hold', 'general', '#6c757d');

-- Group Master
INSERT INTO `group_master` (`client_id`, `group_name`, `description`) VALUES
(1, 'ABC Group', 'ABC Holdings and subsidiaries'),
(1, 'Investment Companies', 'Investment and holding companies'),
(1, 'F&B Companies', 'Food & Beverage companies');

-- ================================================================
-- CRM Data - Lead Sources, Statuses, Ratings
-- ================================================================
INSERT INTO `lead_sources` (`client_id`, `source_name`) VALUES
(1, 'Website'), (1, 'Referral'), (1, 'Cold Call'), (1, 'Email Campaign'),
(1, 'Social Media'), (1, 'Walk-in'), (1, 'Event/Seminar');

INSERT INTO `lead_statuses` (`client_id`, `status_name`, `color`) VALUES
(1, 'New', '#007bff'),
(1, 'Contacted', '#17a2b8'),
(1, 'Qualified', '#28a745'),
(1, 'Proposal Sent', '#ffc107'),
(1, 'Won', '#28a745'),
(1, 'Lost', '#dc3545');

INSERT INTO `lead_ratings` (`client_id`, `rating_name`) VALUES
(1, 'Hot'), (1, 'Warm'), (1, 'Cold');

INSERT INTO `followup_modes` (`client_id`, `mode_name`) VALUES
(1, 'Phone Call'), (1, 'Email'), (1, 'Meeting'), (1, 'Video Call'), (1, 'WhatsApp');

INSERT INTO `followup_agendas` (`client_id`, `agenda_name`) VALUES
(1, 'Initial Discussion'), (1, 'Proposal Review'), (1, 'Price Negotiation'),
(1, 'Contract Signing'), (1, 'Follow-up Check');

-- ================================================================
-- CRM Leads
-- ================================================================
INSERT INTO `leads` (`client_id`, `lead_title`, `contact_name`, `email`, `phone`, `source_id`, `status_id`, `rating_id`, `assigned_to`, `expected_amount`, `description`) VALUES
(1, 'New Company Incorporation - Tech Startup', 'James Loh', 'james@newtech.sg', '91112222', 1, 1, 1, 3, 5000.00, 'Startup looking for incorporation + CSS package'),
(1, 'Annual CSS Package Renewal', 'Alice Ng', 'alice@acmecorp.sg', '92223333', 2, 3, 2, 4, 2400.00, 'Renewal of annual corporate secretary services'),
(1, 'Company Restructuring Advisory', 'Robert Koh', 'robert@globalfirm.sg', '93334444', 2, 4, 1, 3, 15000.00, 'Multi-entity restructuring with share transfers'),
(1, 'GST Registration Support', 'Nancy Foo', 'nancy@retailco.sg', '94445555', 4, 2, 3, 4, 800.00, 'Company needs GST registration'),
(1, 'Nominee Director Service', 'Patrick Ong', 'patrick@overseas.com', '95556666', 3, 1, 2, 3, 3600.00, 'Foreign client needs nominee director');

-- ================================================================
-- CRM Quotations
-- ================================================================
INSERT INTO `quotations` (`client_id`, `lead_id`, `quotation_number`, `quotation_date`, `valid_until`, `total_amount`, `tax_amount`, `grand_total`, `status`, `created_by`) VALUES
(1, 1, 'QT-2025-001', '2025-01-15', '2025-02-14', 5000.00, 450.00, 5450.00, 'Accepted', 1),
(1, 2, 'QT-2025-002', '2025-01-20', '2025-02-19', 2400.00, 216.00, 2616.00, 'Accepted', 1),
(1, 3, 'QT-2025-003', '2025-02-01', '2025-03-02', 15000.00, 1350.00, 16350.00, 'Sent', 1),
(1, 5, 'QT-2025-004', '2025-02-10', '2025-03-11', 3600.00, 324.00, 3924.00, 'Draft', 1);

-- ================================================================
-- CRM Sales Orders
-- ================================================================
INSERT INTO `sales_orders` (`client_id`, `quotation_id`, `order_number`, `order_date`, `total_amount`, `tax_amount`, `grand_total`, `status`, `created_by`) VALUES
(1, 1, 'SO-2025-001', '2025-01-18', 5000.00, 450.00, 5450.00, 'Confirmed', 1),
(1, 2, 'SO-2025-002', '2025-01-25', 2400.00, 216.00, 2616.00, 'Confirmed', 1);

-- ================================================================
-- CRM Invoices
-- ================================================================
INSERT INTO `invoices` (`client_id`, `order_id`, `company_id`, `invoice_number`, `invoice_date`, `due_date`, `subtotal`, `tax_amount`, `total`, `amount_paid`, `balance`, `status`, `created_by`) VALUES
(1, 1, 3, 'INV-2025-001', '2025-01-20', '2025-02-19', 5000.00, 450.00, 5450.00, 5450.00, 0.00, 'Paid', 1),
(1, 2, 1, 'INV-2025-002', '2025-01-28', '2025-02-27', 2400.00, 216.00, 2616.00, 2616.00, 0.00, 'Paid', 1),
(1, NULL, 2, 'INV-2025-003', '2025-02-01', '2025-03-02', 1200.00, 108.00, 1308.00, 0.00, 1308.00, 'Sent', 1),
(1, NULL, 5, 'INV-2025-004', '2025-02-05', '2025-03-06', 3600.00, 324.00, 3924.00, 1962.00, 1962.00, 'Partial', 1),
(1, NULL, 4, 'INV-2025-005', '2025-02-10', '2025-03-11', 1800.00, 162.00, 1962.00, 0.00, 1962.00, 'Draft', 1);

-- ================================================================
-- CRM Projects
-- ================================================================
INSERT INTO `project_statuses` (`client_id`, `status_name`, `color`) VALUES
(1, 'Not Started', '#6c757d'),
(1, 'In Progress', '#007bff'),
(1, 'On Hold', '#ffc107'),
(1, 'Completed', '#28a745'),
(1, 'Cancelled', '#dc3545');

INSERT INTO `task_priorities` (`client_id`, `priority_name`, `color`) VALUES
(1, 'Low', '#28a745'),
(1, 'Medium', '#ffc107'),
(1, 'High', '#fd7e14'),
(1, 'Urgent', '#dc3545');

INSERT INTO `task_groups` (`client_id`, `group_name`) VALUES
(1, 'Incorporation'), (1, 'Annual Filing'), (1, 'Share Transfer'), (1, 'Director Changes'), (1, 'General');

INSERT INTO `projects` (`client_id`, `company_id`, `project_name`, `description`, `start_date`, `end_date`, `status_id`, `priority_id`, `assigned_to`, `budget`, `created_by`) VALUES
(1, 3, 'Global Tech Incorporation', 'Full incorporation service for Global Tech Solutions', '2025-01-10', '2025-02-10', 4, 2, 3, 5000.00, 1),
(1, 1, 'ABC Holdings Annual Filing 2025', 'Annual filing package - AGM, AR, and accounts', '2025-03-01', '2025-06-30', 2, 2, 4, 2400.00, 1),
(1, 5, 'Pinnacle Share Restructuring', 'Share transfer and capital restructuring', '2025-02-01', '2025-04-30', 2, 3, 3, 15000.00, 1),
(1, 7, 'Green Energy Setup', 'Incorporation and setup of Green Energy Solutions', '2025-01-15', '2025-03-15', 4, 1, 4, 3000.00, 1),
(1, NULL, 'Internal System Upgrade', 'Upgrade corporate secretarial management system', '2025-01-01', '2025-06-30', 2, 2, 2, 0.00, 1);

-- ================================================================
-- CRM Tasks
-- ================================================================
INSERT INTO `tasks` (`client_id`, `project_id`, `company_id`, `task_name`, `description`, `task_group_id`, `priority_id`, `status_id`, `assigned_to`, `start_date`, `due_date`, `estimated_hours`, `type`, `created_by`) VALUES
(1, 1, 3, 'Prepare Name Application', 'Apply for company name with ACRA', 1, 2, 4, 3, '2025-01-10', '2025-01-12', 2.00, 2, 1),
(1, 1, 3, 'Draft Constitution', 'Prepare company constitution document', 1, 2, 4, 4, '2025-01-12', '2025-01-15', 4.00, 2, 1),
(1, 1, 3, 'File Incorporation with ACRA', 'Submit all incorporation documents to ACRA', 1, 3, 4, 3, '2025-01-15', '2025-01-20', 3.00, 2, 1),
(1, 2, 1, 'Prepare AGM Notice', 'Draft and send AGM notice to shareholders', 2, 2, 2, 4, '2025-03-01', '2025-03-15', 3.00, 2, 1),
(1, 2, 1, 'Hold AGM', 'Conduct AGM for FY2024', 2, 3, 1, 4, '2025-04-01', '2025-04-15', 4.00, 2, 1),
(1, 2, 1, 'File Annual Return', 'File AR with ACRA within statutory deadline', 2, 4, 1, 3, '2025-04-16', '2025-05-30', 2.00, 2, 1),
(1, 3, 5, 'Due Diligence on Buyers', 'KYC checks on new shareholders', 3, 3, 2, 3, '2025-02-01', '2025-02-15', 8.00, 2, 1),
(1, 3, 5, 'Draft Share Transfer Agreements', 'Prepare STA for all parties', 3, 3, 2, 4, '2025-02-15', '2025-03-15', 12.00, 2, 1),
(1, 5, NULL, 'Migrate data to new system', 'Import existing data', 5, 2, 2, 2, '2025-02-01', '2025-03-31', 40.00, 2, 1),
(1, NULL, 2, 'Follow up on outstanding invoice', 'INV-2025-003 outstanding for XYZ Trading', 5, 3, 1, 4, '2025-03-01', '2025-03-05', 1.00, 3, 1);

-- ================================================================
-- Company Fees (Assigned to companies)
-- ================================================================
INSERT INTO `company_fees` (`company_id`, `fee_type_id`, `fee_name`, `amount`, `currency`, `effective_date`) VALUES
(1, 2, 'Company Secretary Fee (Annual)', 1200.00, 'SGD', '2025-01-01'),
(1, 5, 'Registered Address Fee', 600.00, 'SGD', '2025-01-01'),
(1, 1, 'Annual Return Filing Fee', 60.00, 'SGD', '2025-05-30'),
(2, 2, 'Company Secretary Fee (Annual)', 1200.00, 'SGD', '2025-01-01'),
(2, 5, 'Registered Address Fee', 600.00, 'SGD', '2025-01-01'),
(3, 6, 'Company Incorporation Fee', 1500.00, 'SGD', '2020-01-10'),
(3, 2, 'Company Secretary Fee (Annual)', 1200.00, 'SGD', '2025-01-01'),
(5, 2, 'Company Secretary Fee (Annual)', 2400.00, 'SGD', '2025-01-01'),
(5, 5, 'Registered Address Fee', 1200.00, 'SGD', '2025-01-01');

-- ================================================================
-- Company Bank Accounts
-- ================================================================
INSERT INTO `company_bank_accounts` (`company_id`, `bank_id`, `account_number`, `account_type_id`, `currency`) VALUES
(1, 1, '003-123456-7', 1, 'SGD'),
(1, 2, '601-234567-001', 1, 'SGD'),
(2, 3, '123-456-789-0', 1, 'SGD'),
(3, 1, '003-987654-3', 1, 'SGD'),
(5, 4, 'SC-001-234567', 1, 'SGD'),
(5, 1, '003-567890-1', 4, 'USD'),
(8, 5, 'HSBC-123-456', 1, 'SGD');

-- ================================================================
-- Notifications (sample)
-- ================================================================
INSERT INTO `notifications` (`client_id`, `user_id`, `title`, `message`, `link`, `is_read`) VALUES
(1, 1, 'AGM Due: ABC Holdings', 'AGM for ABC HOLDINGS PTE. LTD. is due by 30 Jun 2026', '/view_company/1', 0),
(1, 1, 'New Lead Assigned', 'Lead "New Company Incorporation - Tech Startup" has been assigned to you', '/crm_leads', 0),
(1, 1, 'Invoice Overdue: XYZ Trading', 'INV-2025-003 for XYZ TRADING PTE. LTD. is overdue', '/crm_invoices', 0),
(1, 1, 'AR Filing Completed', 'Annual Return for SUNRISE F&B PTE. LTD. has been filed successfully', '/view_company/4', 1),
(1, 1, 'Task Completed', 'Task "File Incorporation with ACRA" has been completed for Global Tech Solutions', '/crm_tasks', 1),
(1, 1, 'Director Appointment', 'New director JOHN SMITH appointed to PINNACLE INVESTMENTS PTE. LTD.', '/company_officials/5', 1),
(1, 2, 'New Company Added', 'INFINITY CONSULTING PTE. LTD. has been added as a new company', '/view_company/10', 0),
(1, 3, 'Task Assigned', 'Task "Due Diligence on Buyers" has been assigned to you', '/crm_tasks', 0);

-- ================================================================
-- User Logs (sample)
-- ================================================================
INSERT INTO `user_logs` (`client_id`, `user_id`, `action`, `module`, `record_id`, `log_change`, `ip_address`, `created_at`) VALUES
(1, 1, 'Login', 'auth', NULL, 'User logged in', '192.168.1.100', '2025-02-19 09:00:00'),
(1, 1, 'Created company', 'companies', 10, 'Created INFINITY CONSULTING PTE. LTD.', '192.168.1.100', '2025-02-18 14:30:00'),
(1, 1, 'Updated company', 'companies', 1, 'Updated FYE date for ABC HOLDINGS PTE. LTD.', '192.168.1.100', '2025-02-17 10:15:00'),
(1, 1, 'Filed AR', 'events', 2, 'Filed Annual Return for ABC HOLDINGS PTE. LTD.', '192.168.1.100', '2025-02-16 16:00:00'),
(1, 3, 'Created lead', 'crm', 1, 'Created lead: New Company Incorporation - Tech Startup', '192.168.1.101', '2025-02-15 11:00:00'),
(1, 4, 'Created invoice', 'invoices', 3, 'Created INV-2025-003 for XYZ TRADING PTE. LTD.', '192.168.1.102', '2025-02-14 09:30:00');

-- ================================================================
-- Sealings (sample)
-- ================================================================
INSERT INTO `sealings` (`client_id`, `company_id`, `seal_date`, `document_description`, `sealed_by`) VALUES
(1, 1, '2025-01-15', 'Share Certificate No. 001 - TAN AH KOW (600,000 ordinary shares)', 'SARAH TAN MEI HUI'),
(1, 1, '2025-01-15', 'Share Certificate No. 002 - DAVID LEE WEI MING (400,000 ordinary shares)', 'SARAH TAN MEI HUI'),
(1, 5, '2025-02-01', 'Board Resolution - Approval of FY2024 Financial Statements', 'SARAH TAN MEI HUI'),
(1, 8, '2025-01-20', 'Transfer of Shares - 1,000,000 ordinary shares', 'LIM MEI LING');

-- ================================================================
-- Reminders
-- ================================================================
INSERT INTO `reminder_subjects` (`client_id`, `subject_name`) VALUES
(1, 'AGM Due Date'), (1, 'AR Filing Due'), (1, 'FYE Deadline'),
(1, 'ID Expiry'), (1, 'Service Renewal'), (1, 'Invoice Due');

INSERT INTO `reminders` (`client_id`, `reminder_name`, `subject_id`, `days_before`, `is_active`) VALUES
(1, 'AGM 90 days reminder', 1, 90, 1),
(1, 'AGM 30 days reminder', 1, 30, 1),
(1, 'AR 60 days reminder', 2, 60, 1),
(1, 'AR 14 days reminder', 2, 14, 1),
(1, 'Passport expiry 180 days', 4, 180, 1),
(1, 'Invoice 7 days overdue', 6, -7, 1);

-- ================================================================
-- Invoice Settings
-- ================================================================
INSERT INTO `invoice_settings` (`client_id`, `prefix`, `next_number`, `tax_rate`, `tax_name`, `payment_terms`, `bank_details`, `notes`) VALUES
(1, 'INV', 6, 9.00, 'GST', 30, 'DBS Bank\nAccount Name: YYCS Corporate Services\nAccount Number: 003-123456-7\nPayNow UEN: 201512345A', 'Payment is due within 30 days of invoice date.\nLate payment will incur interest at 1.5% per month.');

-- ================================================================
-- Terms & Conditions
-- ================================================================
INSERT INTO `terms_conditions` (`client_id`, `title`, `content`, `type`) VALUES
(1, 'Standard Service Agreement', 'This agreement is entered into between YYCS Corporate Services Pte Ltd and the Client for the provision of corporate secretarial services...', 'service'),
(1, 'Invoice Payment Terms', '1. Payment is due within 30 days of invoice date.\n2. Late payments will incur interest at 1.5% per month.\n3. All fees quoted are exclusive of GST unless stated otherwise.', 'invoice');

-- ================================================================
-- CRM Additional Settings
-- ================================================================
INSERT INTO `task_masters` (`client_id`, `task_name`) VALUES
(1, 'Incorporation'), (1, 'AGM Filing'), (1, 'AR Filing'), (1, 'Share Transfer'),
(1, 'Director Appointment'), (1, 'Director Cessation'), (1, 'Change of Address'),
(1, 'Change of Company Name'), (1, 'Company Striking Off');

INSERT INTO `cycle_masters` (`client_id`, `cycle_name`) VALUES
(1, 'Monthly'), (1, 'Quarterly'), (1, 'Semi-Annually'), (1, 'Annually'), (1, 'One-Time');

INSERT INTO `ticket_types` (`client_id`, `type_name`) VALUES
(1, 'Bug'), (1, 'Feature Request'), (1, 'Support'), (1, 'General Enquiry');

INSERT INTO `ticket_sources` (`client_id`, `source_name`) VALUES
(1, 'Email'), (1, 'Phone'), (1, 'Web Portal'), (1, 'Walk-in');

INSERT INTO `ticket_priorities` (`client_id`, `priority_name`, `color`) VALUES
(1, 'Low', '#28a745'), (1, 'Medium', '#ffc107'), (1, 'High', '#fd7e14'), (1, 'Critical', '#dc3545');

INSERT INTO `expense_heads` (`client_id`, `head_name`) VALUES
(1, 'ACRA Filing Fees'), (1, 'Courier / Postage'), (1, 'Printing'),
(1, 'Transport'), (1, 'Miscellaneous');

INSERT INTO `uom_master` (`client_id`, `uom_name`) VALUES
(1, 'Each'), (1, 'Hour'), (1, 'Day'), (1, 'Month'), (1, 'Year'), (1, 'Package');

INSERT INTO `register_footers` (`client_id`, `register_type`, `footer_text`) VALUES
(1, 'register_of_directors', 'I certify that the above is a true and correct register of directors.'),
(1, 'register_of_shareholders', 'I certify that the above is a true and correct register of members/shareholders.'),
(1, 'register_of_secretaries', 'I certify that the above is a true and correct register of company secretaries.');

-- ================================================================
-- Email Templates
-- ================================================================
INSERT INTO `email_templates` (`client_id`, `template_name`, `subject`, `body`, `variables`) VALUES
(1, 'AGM Reminder', 'Reminder: AGM Due for {company_name}', 'Dear {contact_person},\n\nThis is a reminder that the Annual General Meeting for {company_name} is due by {agm_due_date}.\n\nPlease ensure all necessary preparations are made.\n\nBest regards,\nYYCS Corporate Services', '{company_name}, {contact_person}, {agm_due_date}'),
(1, 'AR Filing Confirmation', 'Annual Return Filed: {company_name}', 'Dear {contact_person},\n\nWe are pleased to confirm that the Annual Return for {company_name} has been successfully filed with ACRA on {filing_date}.\n\nBest regards,\nYYCS Corporate Services', '{company_name}, {contact_person}, {filing_date}'),
(1, 'Invoice Reminder', 'Payment Reminder: Invoice {invoice_number}', 'Dear {contact_person},\n\nThis is a friendly reminder that invoice {invoice_number} dated {invoice_date} for the amount of {amount} is due for payment by {due_date}.\n\nPlease arrange for payment at your earliest convenience.\n\nBest regards,\nYYCS Corporate Services', '{contact_person}, {invoice_number}, {invoice_date}, {amount}, {due_date}');

-- ================================================================
-- Teams
-- ================================================================
INSERT INTO `teams` (`client_id`, `team_name`, `description`, `leader_id`) VALUES
(1, 'CSS Team A', 'Corporate secretarial team handling companies A-M', 3),
(1, 'CSS Team B', 'Corporate secretarial team handling companies N-Z', 4),
(1, 'CRM Team', 'Sales and CRM management team', 3);

INSERT INTO `team_members` (`team_id`, `user_id`) VALUES
(1, 3), (1, 5),
(2, 4), (2, 6),
(3, 3), (3, 4);

SET FOREIGN_KEY_CHECKS = 1;
