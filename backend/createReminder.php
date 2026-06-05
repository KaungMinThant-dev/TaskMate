<?php
// 🌟 CORS Policy Settings ခွင့်ပြုခြင်း
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

include 'db_connect.php';

// Frontend မှ ပေးပို့လိုက်သော JSON Payload အား ယူခြင်း
$data = json_decode(file_get_contents("php://input"), true);

$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$title = isset($data['title']) ? trim($data['title']) : '';
$subject_id = (!empty($data['subject_id'])) ? intval($data['subject_id']) : null;
$reminder_date = isset($data['reminder_date']) ? trim($data['reminder_date']) : '';
$reminder_time = isset($data['reminder_time']) ? trim($data['reminder_time']) : '';
$urgency_level = isset($data['urgency_level']) ? trim($data['urgency_level']) : 'medium';

// 🛡️ Data Validation Guard
if ($user_id <= 0 || empty($title) || empty($reminder_date) || empty($reminder_time)) {
    echo json_encode(["status" => "error", "message" => "Incomplete data fields received!"]);
    exit();
}

try {
    // 🗄️ reminders Table ထဲသို့ ဒေတာအသစ် ကွက်တိ သွင်းခြင်း
    $query = "INSERT INTO reminders (user_id, title, subject_id, reminder_date, reminder_time, urgency_level, status) 
              VALUES (?, ?, ?, ?, ?, ?, 'active')";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id, $title, $subject_id, $reminder_date, $reminder_time, $urgency_level]);

    echo json_encode(["status" => "success", "message" => "New reminder scheduled successfully!"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
}
?>