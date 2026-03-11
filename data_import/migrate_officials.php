<?php
/**
 * Migrate company_officials records into dedicated tables
 * 
 * The production DB dump stores directors, shareholders, secretaries, and auditors
 * in the generic `company_officials` table, but the app's controllers query
 * the dedicated `directors`, `shareholders`, `secretaries`, `auditors` tables.
 * 
 * This script copies the data from company_officials into those tables.
 * It is idempotent — skips if the dedicated tables already have data.
 */

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'corporate_secretary';

$dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
$opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opts);
} catch (PDOException $e) {
    echo "DB connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check if migration already done (dedicated tables have data)
$dirCount = $pdo->query("SELECT COUNT(*) FROM directors")->fetchColumn();
$shCount  = $pdo->query("SELECT COUNT(*) FROM shareholders")->fetchColumn();
$secCount = $pdo->query("SELECT COUNT(*) FROM secretaries")->fetchColumn();
$audCount = $pdo->query("SELECT COUNT(*) FROM auditors")->fetchColumn();

if ($dirCount > 0 || $shCount > 0 || $secCount > 0 || $audCount > 0) {
    echo "Officials migration: Dedicated tables already have data (directors={$dirCount}, shareholders={$shCount}, secretaries={$secCount}, auditors={$audCount}). Skipping.\n";
    exit(0);
}

// Check company_officials has data
$coCount = $pdo->query("SELECT COUNT(*) FROM company_officials")->fetchColumn();
if ($coCount == 0) {
    echo "Officials migration: company_officials table is empty. Nothing to migrate.\n";
    exit(0);
}

echo "Officials migration: Found {$coCount} records in company_officials. Migrating...\n";

// Get all records grouped by type
$allOfficials = $pdo->query("SELECT * FROM company_officials ORDER BY id")->fetchAll();

$stats = ['director' => 0, 'shareholder' => 0, 'secretary' => 0, 'auditor' => 0, 'skipped' => 0];

$pdo->beginTransaction();

try {
    // Prepare insert statements for each dedicated table
    $insertDirector = $pdo->prepare("
        INSERT INTO directors (company_id, member_id, role, name, id_type, id_number, 
            nationality, email, contact_number, date_of_appointment, date_of_cessation, status, 
            created_at, updated_at)
        VALUES (?, ?, 'director', ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?)
    ");

    $insertShareholder = $pdo->prepare("
        INSERT INTO shareholders (company_id, member_id, shareholder_type, name, id_type, id_number,
            nationality, email, contact_number, date_of_appointment, date_of_cessation, status,
            created_at, updated_at)
        VALUES (?, ?, 'Individual', ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?)
    ");

    $insertSecretary = $pdo->prepare("
        INSERT INTO secretaries (company_id, member_id, secretary_type, name, id_type, id_number,
            nationality, email, contact_number, date_of_appointment, date_of_cessation, status,
            created_at, updated_at)
        VALUES (?, ?, 'Individual', ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?)
    ");

    $insertAuditor = $pdo->prepare("
        INSERT INTO auditors (company_id, name, firm_name, address, date_of_appointment, 
            date_of_cessation, status, created_at, updated_at)
        VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?)
    ");

    // Also fetch member details for enrichment (nationality, date_of_birth, etc.)
    $memberCache = [];
    $members = $pdo->query("SELECT * FROM members")->fetchAll();
    foreach ($members as $m) {
        $memberCache[$m->id] = $m;
    }

    foreach ($allOfficials as $co) {
        $type = strtolower(trim($co->official_type));
        
        // Enrich from member record if available
        $member = isset($co->member_id) && isset($memberCache[$co->member_id]) 
            ? $memberCache[$co->member_id] : null;
        
        $nationality = $member->nationality ?? null;
        $idType = $co->id_type ?? ($member->id_type ?? null);
        $idNumber = $co->id_number ?? ($member->id_number ?? null);
        $email = $co->email ?? ($member->email ?? null);
        $contact = $co->contact_number ?? ($member->contact_number ?? null);

        switch ($type) {
            case 'director':
                $insertDirector->execute([
                    $co->company_id, $co->member_id, $co->name,
                    $idType, $idNumber, $email, $contact,
                    $co->date_of_appointment, $co->date_of_cessation, 
                    $co->status ?? 'Active', $co->created_at, $co->updated_at
                ]);
                $stats['director']++;
                break;

            case 'shareholder':
                $insertShareholder->execute([
                    $co->company_id, $co->member_id, $co->name,
                    $idType, $idNumber, $email, $contact,
                    $co->date_of_appointment, $co->date_of_cessation,
                    $co->status ?? 'Active', $co->created_at, $co->updated_at
                ]);
                $stats['shareholder']++;
                break;

            case 'secretary':
                $insertSecretary->execute([
                    $co->company_id, $co->member_id, $co->name,
                    $idType, $idNumber, $email, $contact,
                    $co->date_of_appointment, $co->date_of_cessation,
                    $co->status ?? 'Active', $co->created_at, $co->updated_at
                ]);
                $stats['secretary']++;
                break;

            case 'auditor':
                $insertAuditor->execute([
                    $co->company_id, $co->name, $co->address,
                    $co->date_of_appointment, $co->date_of_cessation,
                    $co->status ?? 'Active', $co->created_at, $co->updated_at
                ]);
                $stats['auditor']++;
                break;

            default:
                // Other types (manager, representative, etc.) stay in company_officials only
                $stats['skipped']++;
                break;
        }
    }

    $pdo->commit();
    
    echo "Officials migration complete!\n";
    echo "  Directors:    {$stats['director']}\n";
    echo "  Shareholders: {$stats['shareholder']}\n";
    echo "  Secretaries:  {$stats['secretary']}\n";
    echo "  Auditors:     {$stats['auditor']}\n";
    echo "  Other (kept in company_officials): {$stats['skipped']}\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Officials migration FAILED: " . $e->getMessage() . "\n";
    exit(1);
}
