<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid User ID."]);
    exit();
}

try {
    // 🕵️‍♂️ ၁။ ကျောင်းသား၏ users table ထဲ၌ telegram_chat_id ရှိမရှိ အရင်လှမ်းစစ်ခြင်း
    $userQuery = "SELECT telegram_chat_id FROM users WHERE user_id = ?";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->execute([$user_id]);
    $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
    $telegram_chat_id = $userRow ? $userRow['telegram_chat_id'] : null;

    // 🗄️ ၂။ ၎င်းကျောင်းသား၏ Active ဖြစ်နေသော Reminders စာရင်းအား အချိန်အလိုက် စီ၍ ဆွဲထုတ်ခြင်း
$query = "SELECT * FROM reminders 
          WHERE user_id = ? 
          AND status = 'active' 
          ORDER BY reminder_date ASC, reminder_time ASC";
              
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🚀 ရလဒ်အားလုံးကို React ဆီသို့ ဒိုင်ရိုက် ပစ်လွှတ်ခြင်း
    echo json_encode([
        "status" => "success",
        "telegram_chat_id" => $telegram_chat_id,
        "data" => $reminders
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
}
?>