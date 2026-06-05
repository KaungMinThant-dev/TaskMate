<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$reminder_id = isset($data['reminder_id']) ? intval($data['reminder_id']) : 0;

if ($reminder_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid Reminder ID."]);
    exit();
}

try {
    // ဒေတာဘေ့စ်ထဲမှ လုံးဝ ဖြတ်ထုတ်ပစ်ခြင်း
    $stmt = $conn->prepare("DELETE FROM reminders WHERE reminder_id = ?");
    $stmt->execute([$reminder_id]);

    echo json_encode(["status" => "success", "message" => "Reminder deleted successfully!"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
}
?>