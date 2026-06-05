<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = isset($data['username']) ? trim($data['username']) : '';
$account_type = isset($data['account_type']) ? trim($data['account_type']) : '';

if (empty($username) || empty($account_type)) {
    echo json_encode(["status" => "error", "message" => "Missing data!"]);
    exit();
}

try {
    // 🛡️ 🌟 SECURITY GUARD 2: Update မလုပ်မီ ၎င်း User ၏ လက်ရှိ Real-Time Status အား ထပ်မံစစ်ဆေးခြင်း
    if ($account_type === 'premium') {
        $verifyStmt = $conn->prepare("SELECT account_type FROM users WHERE username = ?");
        $verifyStmt->execute([$username]);
        $current_status = $verifyStmt->fetchColumn();

        if (strtolower($current_status) !== 'pending') {
            echo json_encode(["status" => "error", "message" => "Transaction Aborted: User state is not pending!"]);
            exit();
        }
    }

    // စစ်ဆေးချက်အောင်မြင်မှသာ SQL Update မောင်းနှင်မည်
    $stmt = $conn->prepare("UPDATE users SET account_type = ? WHERE username = ?");
    $stmt->execute([$account_type, $username]);
    
    echo json_encode(["status" => "success", "message" => "Database updated successfully!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $e->getMessage()]);
}
?>