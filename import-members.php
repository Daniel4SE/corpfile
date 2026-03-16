<?php
$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'corpfile';

$pdo = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$memberCols = [
    'gender VARCHAR(20) DEFAULT NULL', 'alias_name VARCHAR(255) DEFAULT NULL',
    'date_of_birth DATE DEFAULT NULL', 'country_of_birth VARCHAR(100) DEFAULT NULL',
    'risk_assessment_rating VARCHAR(20) DEFAULT NULL', 'additional_notes TEXT DEFAULT NULL',
    'father_name VARCHAR(255) DEFAULT NULL', 'mother_name VARCHAR(255) DEFAULT NULL',
    'spouse_name VARCHAR(255) DEFAULT NULL', 'phone VARCHAR(50) DEFAULT NULL',
    'residential_address TEXT DEFAULT NULL', 'foreign_address TEXT DEFAULT NULL',
    'contact_address TEXT DEFAULT NULL', "default_address_type VARCHAR(30) DEFAULT 'Contact Address'",
];
foreach ($memberCols as $colDef) {
    $colName = explode(' ', $colDef)[0];
    $exists = $pdo->query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema='{$dbName}' AND table_name='members' AND column_name='{$colName}'")->fetchColumn();
    if (!$exists) {
        $pdo->exec("ALTER TABLE members ADD COLUMN {$colDef}");
        echo "  Added members.{$colName}\n";
    }
}

$pdo->exec("CREATE TABLE IF NOT EXISTS member_identifications (
    id INT AUTO_INCREMENT PRIMARY KEY, member_id INT NOT NULL, id_slot INT DEFAULT 1,
    id_type VARCHAR(50), id_number VARCHAR(100), id_expiry_date DATE DEFAULT NULL,
    id_issued_date DATE DEFAULT NULL, id_issued_country VARCHAR(100) DEFAULT NULL,
    client_id INT DEFAULT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_member (member_id)
)");

$json = file_get_contents(__DIR__ . '/scraped-members.json');
$members = json_decode($json, true);

$clientRow = $pdo->query("SELECT id FROM clients LIMIT 1")->fetch(PDO::FETCH_OBJ);
$clientId = $clientRow ? $clientRow->id : 1;

echo "Importing " . count($members) . " members into client_id={$clientId}\n";

function parseDate($d) {
    if (!$d) return null;
    $d = trim($d);
    if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $d, $m)) return "{$m[3]}-{$m[2]}-{$m[1]}";
    if (preg_match('#^(\d{4})-(\d{2})-(\d{2})$#', $d)) return $d;
    return null;
}

$inserted = 0;
$updated = 0;
$idDocs = 0;

foreach ($members as $m) {
    $p = $m['profile'] ?? [];
    if (!empty($p['error']) || empty($p['name'])) continue;

    $name = $p['name'];
    $existing = $pdo->prepare("SELECT id FROM members WHERE name = ? AND client_id = ?");
    $existing->execute([$name, $clientId]);
    $row = $existing->fetch(PDO::FETCH_OBJ);

    $fields = [
        'name' => $name,
        'gender' => $p['gender'] ?: null,
        'alias_name' => $p['alias'] ?: null,
        'nationality' => $p['nationality'] ?: null,
        'date_of_birth' => parseDate($p['date_of_birth']),
        'country_of_birth' => $p['country_of_birth'] ?: null,
        'risk_assessment_rating' => $p['risk_rating'] ?: null,
        'additional_notes' => $p['additional_notes'] ?: null,
        'residential_address' => $p['residential_address'] ?: null,
        'foreign_address' => $p['foreign_address'] ?: null,
        'contact_address' => $p['contact_address'] ?: null,
        'default_address_type' => $p['default_address'] ?: 'Contact Address',
        'father_name' => $p['father_name'] ?: null,
        'mother_name' => $p['mother_name'] ?: null,
        'spouse_name' => $p['spouse_name'] ?: null,
        'email' => $p['email'] ?: null,
        'phone' => $p['mobile'] ?: $p['phone'] ?: null,
        'status' => $p['status'] ?: 'Active',
        'client_id' => $clientId,
    ];

    if ($row) {
        $sets = [];
        $vals = [];
        foreach ($fields as $k => $v) {
            if ($k === 'client_id' || $k === 'name') continue;
            $sets[] = "{$k} = ?";
            $vals[] = $v;
        }
        $vals[] = $row->id;
        $pdo->prepare("UPDATE members SET " . implode(', ', $sets) . " WHERE id = ?")->execute($vals);
        $memberId = $row->id;
        $updated++;
    } else {
        $cols = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $stmt = $pdo->prepare("INSERT INTO members ({$cols}) VALUES ({$placeholders})");
        $stmt->execute(array_values($fields));
        $memberId = $pdo->lastInsertId();
        $inserted++;
    }

    if (!empty($m['ids'])) {
        $pdo->prepare("DELETE FROM member_identifications WHERE member_id = ?")->execute([$memberId]);
        foreach ($m['ids'] as $slot => $id) {
            $pdo->prepare("INSERT INTO member_identifications (member_id, id_slot, id_type, id_number, id_expiry_date, id_issued_date, id_issued_country, client_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
                ->execute([
                    $memberId, $slot + 1, $id['type'] ?: null, $id['number'] ?: null,
                    parseDate($id['expiry']), parseDate($id['issued']),
                    $id['country'] ?: null, $clientId,
                ]);
            $idDocs++;
        }
    }
}

echo "Done! Inserted: {$inserted}, Updated: {$updated}, ID docs: {$idDocs}\n";
