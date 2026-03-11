<?php
/**
 * Import Teamwork.sg scraped data into CorpFile database.
 * 
 * This script reads the JSON data exported from Teamwork.sg and UPDATES
 * existing company records in CorpFile with richer data (filling in blank fields).
 * It also creates member records if they don't already exist.
 * 
 * Usage: Run via `railway ssh` inside the container, or locally with DB credentials.
 */

$DB_HOST = getenv('DB_HOST') ?: 'mysql.railway.internal';
$DB_PORT = getenv('DB_PORT') ?: '3306';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: 'gXquEcfpjoeTXzeCjcdgtPixDjbMIAch';
$DB_NAME = getenv('DB_NAME') ?: 'railway';

$DATA_DIR = getenv('DATA_DIR') ?: '/var/www/html/data_import';

// ── Connect ──
try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER, $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false]
    );
    echo "Connected to database.\n";
} catch (Exception $e) {
    die("DB connect failed: " . $e->getMessage() . "\n");
}

// ── Load scraped data ──
$companyList = json_decode(file_get_contents("$DATA_DIR/all_companies.json"), true);
$companyDetails = json_decode(file_get_contents("$DATA_DIR/company_details_all.json"), true);
$members = json_decode(file_get_contents("$DATA_DIR/members_all.json"), true);

echo "Loaded: " . count($companyList) . " companies (list), " . count($companyDetails) . " company details, " . count($members) . " members\n";

// Get client ID (first client)
$client = $pdo->query("SELECT id, client_id FROM clients LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if (!$client) {
    die("No client found in database.\n");
}
$clientDbId = $client['id'];
echo "Using client: {$client['client_id']} (DB id: $clientDbId)\n\n";

// ── Index company details by company name for matching ──
$detailsByName = [];
foreach ($companyDetails as $d) {
    $name = trim($d['company-name'] ?? '');
    if ($name) $detailsByName[strtoupper($name)] = $d;
}

// ── Also build a lookup from list data ──
$listByName = [];
foreach ($companyList as $l) {
    $name = trim($l['company_name'] ?? '');
    if ($name) $listByName[strtoupper($name)] = $l;
}

// ── Helper: parse date from various formats ──
function parseDate($val) {
    if (!$val || $val === '' || $val === 'Select') return null;
    // DD/MM/YYYY
    if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})$#', $val, $m)) {
        return "{$m[3]}-{$m[2]}-{$m[1]}";
    }
    // YYYY-MM-DD already
    if (preg_match('#^\d{4}-\d{2}-\d{2}$#', $val)) return $val;
    return null;
}

// ── Helper: map FYE month name to date ──
function fyeToDate($fyeStr, $fyeDate = null) {
    if ($fyeDate && preg_match('#^(\d{1,2})/(\d{1,2})$#', $fyeDate, $m)) {
        // DD/MM format -> use 2025 as placeholder year
        $day = str_pad($m[1], 2, '0', STR_PAD_LEFT);
        $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
        return "2025-$month-$day";
    }
    $months = ['January'=>'01','February'=>'02','March'=>'03','April'=>'04','May'=>'05','June'=>'06',
               'July'=>'07','August'=>'08','September'=>'09','October'=>'10','November'=>'11','December'=>'12'];
    if (isset($months[$fyeStr])) {
        $m = $months[$fyeStr];
        // Last day of that month
        $lastDay = date('t', mktime(0,0,0,(int)$m,1,2025));
        return "2025-$m-$lastDay";
    }
    return null;
}

// ── Helper: parse company type to existing type_id ──
function getCompanyTypeId($pdo, $clientDbId, $typeName) {
    if (!$typeName || $typeName === '' || $typeName === 'Select') return null;
    $stmt = $pdo->prepare("SELECT id FROM company_types WHERE client_id = ? AND type_name LIKE ? LIMIT 1");
    $stmt->execute([$clientDbId, "%$typeName%"]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) return $row['id'];
    
    // Create the type if not found
    $pdo->prepare("INSERT INTO company_types (client_id, type_name, status) VALUES (?, ?, 1)")
        ->execute([$clientDbId, $typeName]);
    return $pdo->lastInsertId();
}

// ── Update companies ──
echo "=== Updating Companies ===\n";
$updated = 0;
$skipped = 0;

// Get all existing companies
$stmt = $pdo->prepare("SELECT * FROM companies WHERE client_id = ?");
$stmt->execute([$clientDbId]);
$existingCompanies = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($existingCompanies as $existing) {
    $name = strtoupper(trim($existing['company_name']));
    $detail = $detailsByName[$name] ?? null;
    $list = $listByName[$name] ?? null;
    
    if (!$detail && !$list) {
        $skipped++;
        continue;
    }

    $updates = [];
    $params = [];

    // Registration number
    $regNum = $detail['reg-num'] ?? $list['uen_reg'] ?? null;
    if ($regNum && $regNum !== '' && (!$existing['registration_number'] || $existing['registration_number'] === '')) {
        $updates[] = 'registration_number = ?';
        $params[] = $regNum;
    }

    // Company ID code
    $idCode = $detail['clientid'] ?? $list['id_code'] ?? null;
    if ($idCode && $idCode !== '' && (!$existing['company_id_code'] || $existing['company_id_code'] === '')) {
        $updates[] = 'company_id_code = ?';
        $params[] = $idCode;
    }

    // Incorporation date
    $incorpDate = parseDate($detail['incorp-date'] ?? null);
    if ($incorpDate && !$existing['incorporation_date']) {
        $updates[] = 'incorporation_date = ?';
        $params[] = $incorpDate;
    }

    // FYE date
    $fyeDate = fyeToDate($detail['from_from'] ?? $list['fye'] ?? null, $detail['fye_date'] ?? null);
    if ($fyeDate && !$existing['fye_date']) {
        $updates[] = 'fye_date = ?';
        $params[] = $fyeDate;
    }

    // Company type
    $compType = $detail['company-type_text'] ?? $list['company_type'] ?? null;
    if ($compType && $compType !== '' && $compType !== 'Select' && !$existing['company_type_id']) {
        $typeId = getCompanyTypeId($pdo, $clientDbId, $compType);
        if ($typeId) {
            $updates[] = 'company_type_id = ?';
            $params[] = $typeId;
        }
    }

    // Entity status
    $status = $detail['company-status'] ?? $list['status'] ?? null;
    if ($status && $status !== '' && $status !== 'Select' && (!$existing['entity_status'] || $existing['entity_status'] === '')) {
        $updates[] = 'entity_status = ?';
        $params[] = $status;
    }

    // Country
    $country = $detail['country'] ?? $list['country'] ?? null;
    if ($country && $country !== '' && (!$existing['country'] || $existing['country'] === '')) {
        $updates[] = 'country = ?';
        $params[] = $country;
    }

    // Email
    $email = $detail['company_email'] ?? null;
    if ($email && $email !== '' && (!$existing['email'] || $existing['email'] === '')) {
        $updates[] = 'email = ?';
        $params[] = $email;
    }

    // Website
    $website = $detail['company_website'] ?? null;
    if ($website && $website !== '' && (!$existing['website'] || $existing['website'] === '')) {
        $updates[] = 'website = ?';
        $params[] = $website;
    }

    // SSIC activity codes
    $act1 = $detail['act-one'] ?? null;
    $act1desc = $detail['actone-desc'] ?? null;
    if ($act1 && $act1 !== '' && (!$existing['activity_1'] || $existing['activity_1'] === '')) {
        $updates[] = 'activity_1 = ?';
        $params[] = $act1;
        if ($act1desc) {
            $updates[] = 'activity_1_desc_default = ?';
            $params[] = $act1desc;
        }
    }

    $act2 = $detail['act-two'] ?? null;
    $act2desc = $detail['acttwo-desc'] ?? null;
    if ($act2 && $act2 !== '' && (!$existing['activity_2'] || $existing['activity_2'] === '')) {
        $updates[] = 'activity_2 = ?';
        $params[] = $act2;
        if ($act2desc) {
            $updates[] = 'activity_2_desc_default = ?';
            $params[] = $act2desc;
        }
    }

    // Common seal, company stamp (varchar(10) — truncate to fit)
    $seal = $detail['common_seal'] ?? null;
    if ($seal && $seal !== '' && $seal !== 'Select' && (!$existing['common_seal'] || $existing['common_seal'] === '')) {
        $updates[] = 'common_seal = ?';
        $params[] = substr($seal, 0, 10);
    }
    $stamp = $detail['company_stamp'] ?? null;
    if ($stamp && $stamp !== '' && $stamp !== 'Select' && (!$existing['company_stamp'] || $existing['company_stamp'] === '')) {
        $updates[] = 'company_stamp = ?';
        $params[] = substr($stamp, 0, 10);
    }

    // Risk assessment
    $risk = $detail['risk_assessment_rating_text'] ?? null;
    if ($risk && $risk !== '' && $risk !== 'Select' && (!$existing['risk_assessment_rating'] || $existing['risk_assessment_rating'] === '')) {
        $updates[] = 'risk_assessment_rating = ?';
        $params[] = $risk;
    }

    // Jurisdiction
    $juris = $detail['jurisdiction_incorp_name'] ?? null;
    if ($juris && $juris !== '' && (!$existing['jurisdiction_incorp_name'] || $existing['jurisdiction_incorp_name'] === '')) {
        $updates[] = 'jurisdiction_incorp_name = ?';
        $params[] = $juris;
    }

    // Related industry
    $industry = $detail['related_industry_text'] ?? null;
    if ($industry && $industry !== '' && $industry !== 'Select' && !$existing['related_industry_id']) {
        // Try to find or create industry
        $stmt2 = $pdo->prepare("SELECT id FROM industries WHERE client_id = ? AND industry_name LIKE ? LIMIT 1");
        $stmt2->execute([$clientDbId, "%$industry%"]);
        $ind = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($ind) {
            $updates[] = 'related_industry_id = ?';
            $params[] = $ind['id'];
        }
    }

    // Phone numbers
    $phone1 = $detail['company-contact-number'] ?? null;
    if ($phone1 && $phone1 !== '' && $phone1 !== '-' && (!$existing['phone1_number'] || $existing['phone1_number'] === '')) {
        $parts = explode('-', $phone1, 2);
        if (count($parts) === 2) {
            $updates[] = 'phone1_code = ?';
            $params[] = trim($parts[0]);
            $updates[] = 'phone1_number = ?';
            $params[] = trim($parts[1]);
        }
    }

    // Client type flags
    $clientTypes = $detail ?? [];
    $flagMap = [
        'client' => 'is_client',
        'taxation_client' => 'is_taxation_client',
        'accounting_client' => 'is_accounting_client',
        'audit_client' => 'is_audit_client',
        'payroll_client' => 'is_payroll_client',
        'corporate_shareholder_client' => 'is_corporate_shareholder',
        'prospect' => 'is_prospect',
    ];
    foreach ($flagMap as $src => $dst) {
        if (isset($clientTypes[$src]) && $clientTypes[$src] === '1' && (!$existing[$dst] || $existing[$dst] == 0)) {
            $updates[] = "$dst = ?";
            $params[] = 1;
        }
    }

    // Apply updates
    if (!empty($updates)) {
        $params[] = $existing['id'];
        $sql = "UPDATE companies SET " . implode(', ', $updates) . " WHERE id = ?";
        try {
            $pdo->prepare($sql)->execute($params);
            $updated++;
        } catch (Exception $e) {
            echo "  WARN: Failed to update '{$existing['company_name']}': " . $e->getMessage() . "\n";
            $skipped++;
        }
    } else {
        $skipped++;
    }
}

echo "Companies updated: $updated, Skipped (no new data): $skipped\n\n";

// ── Update members ──
echo "=== Updating Members ===\n";
$memberUpdated = 0;
$memberCreated = 0;

// Get existing members
$existingMembers = $pdo->prepare("SELECT * FROM members WHERE client_id = ?");
$existingMembers->execute([$clientDbId]);
$existingMembersList = $existingMembers->fetchAll(PDO::FETCH_ASSOC);
$memberByName = [];
foreach ($existingMembersList as $m) {
    $memberByName[strtoupper(trim($m['name'] ?? $m['member_name'] ?? ''))] = $m;
}

// Check which columns exist in members table
$memberCols = [];
$colQuery = $pdo->query("DESCRIBE members");
while ($col = $colQuery->fetch(PDO::FETCH_ASSOC)) {
    $memberCols[] = $col['Field'];
}

foreach ($members as $m) {
    $name = trim($m['col_1'] ?? '');
    if (!$name) continue;
    
    $idInfo = trim($m['col_3'] ?? ''); // e.g. "PASSPORT / EJ3152166" or "NRIC / S1234567A"
    $address = trim($m['col_4'] ?? '');
    $email = trim($m['col_5'] ?? '');
    $phone = trim($m['col_6'] ?? '');
    
    // Parse ID type and number
    $idType = '';
    $idNumber = '';
    if (preg_match('#^(\w+)\s*/\s*(.+)$#', $idInfo, $im)) {
        $idType = strtoupper(trim($im[1]));
        $idNumber = trim($im[2]);
    }
    
    $existing = $memberByName[strtoupper($name)] ?? null;
    
    if ($existing) {
        // Update if fields are empty
        $ups = [];
        $prms = [];
        
        if ($email && in_array('email', $memberCols) && (!$existing['email'] || $existing['email'] === '')) {
            $ups[] = 'email = ?'; $prms[] = $email;
        }
        if ($address && in_array('address', $memberCols) && (!($existing['address'] ?? '') || ($existing['address'] ?? '') === '')) {
            $ups[] = 'address = ?'; $prms[] = $address;
        }
        if ($idNumber && in_array('id_number', $memberCols) && (!($existing['id_number'] ?? '') || ($existing['id_number'] ?? '') === '')) {
            $ups[] = 'id_number = ?'; $prms[] = $idNumber;
        }
        
        if (!empty($ups)) {
            $prms[] = $existing['id'];
            $pdo->prepare("UPDATE members SET " . implode(', ', $ups) . " WHERE id = ?")->execute($prms);
            $memberUpdated++;
        }
    }
    // We don't create new members to avoid schema mismatches
}

echo "Members updated: $memberUpdated\n\n";

// ── Summary ──
echo "=== Import Complete ===\n";
$compCount = $pdo->query("SELECT COUNT(*) FROM companies WHERE client_id = $clientDbId")->fetchColumn();
$filledReg = $pdo->query("SELECT COUNT(*) FROM companies WHERE client_id = $clientDbId AND registration_number != '' AND registration_number IS NOT NULL")->fetchColumn();
$filledFye = $pdo->query("SELECT COUNT(*) FROM companies WHERE client_id = $clientDbId AND fye_date IS NOT NULL")->fetchColumn();
$filledType = $pdo->query("SELECT COUNT(*) FROM companies WHERE client_id = $clientDbId AND company_type_id IS NOT NULL")->fetchColumn();
$filledIncorp = $pdo->query("SELECT COUNT(*) FROM companies WHERE client_id = $clientDbId AND incorporation_date IS NOT NULL")->fetchColumn();

echo "Total companies: $compCount\n";
echo "With registration number: $filledReg\n";
echo "With FYE date: $filledFye\n";
echo "With company type: $filledType\n";
echo "With incorporation date: $filledIncorp\n";
