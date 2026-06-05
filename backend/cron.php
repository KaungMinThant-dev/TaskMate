<?php
/* ==========================================================================
   🌐 DYNAMIC CORS Security Handshake (Supports BOTH Port 3000 & 3001)
   ========================================================================== */
// React Engine Port 3000 နှင့် 3001 နှစ်ခုစလုံးအား Environment Compatibility ရှိအောင် ခွင့်ပြုချက်ပေးခြင်း Matrix
$allowed_origins = ['http://localhost:3000', 'http://localhost:3001'];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $origin);
} else {
    // Default Fallback Standard
    header("Access-Control-Allow-Origin: http://localhost:3000");
}

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Browser Preflight CORS Setup Safe Bypass
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

/* ==========================================================================
   🐛 Telemetry Error Debugging Core Configurations
   ========================================================================== */
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Task Scheduler က ဘယ်နေရာကနေမောင်းမောင်း db_connect.php ကို တည့်တည့်ရှာတွေ့စေရန်
include __DIR__ . '/db_connect.php';

date_default_timezone_set('Asia/Yangon');
$current_date = date('Y-m-d');
$current_time = date('H:i');

try {
    // ၁။ Notification ပို့ရန် လိုအပ်သော Reminders များအား အချိန်ကိုက် ရှာဖွေခြင်း
    $query = "SELECT r.*, u.telegram_chat_id 
              FROM reminders r 
              JOIN users u ON r.user_id = u.user_id 
              WHERE r.reminder_date = ? 
              AND DATE_FORMAT(r.reminder_time, '%H:%i') = ? 
              AND r.is_sent = 0 
              AND u.telegram_chat_id IS NOT NULL";

    $stmt = $conn->prepare($query);
    $stmt->execute([$current_date, $current_time]);
    $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($reminders)) {
        // React Response UI အဆင်ပြေစေရန် JSON format ဖြင့် Output ထုတ်ပေးခြင်း
        echo json_encode(["status" => "success", "message" => "No pending reminders for " . $current_time]);
        exit;
    }

    $telegram_token = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE";
    $processed_tasks = [];

    foreach ($reminders as $rem) {
        $chat_id = $rem['telegram_chat_id'];
        
        // 🔔 အပိုင်း (က) - စာသားပို့ခြင်း
        $message = "🔔 *Reminder Alert!*" . PHP_EOL . "📌 *Task:* " . $rem['title'];
        $url_text = "https://api.telegram.org/bot" . $telegram_token . "/sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($message) . "&parse_mode=Markdown";
        
        $text_response = @file_get_contents($url_text);

        // 🎧 အပိုင်း (ခ) - အသံဖိုင် (Voice) ပို့ခြင်း
        $voice_path = __DIR__ . "/reminder_alarm.ogg";
        if (file_exists($voice_path)) {
            $url_voice = "https://api.telegram.org/bot" . $telegram_token . "/sendVoice";
            $post_fields = [
                'chat_id' => $chat_id,
                'voice' => new CURLFile($voice_path)
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_voice);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $voice_response = curl_exec($ch);
            curl_close($ch);
        }

        // ၃။ ပို့ပြီးကြောင်း Database တွင် အပြီးသတ် မှတ်သားခြင်း (Transaction Duplicate Lock)
        $updateStmt = $conn->prepare("UPDATE reminders SET is_sent = 1 WHERE reminder_id = ?");
        $updateStmt->execute([$rem['reminder_id']]);
        
        $processed_tasks[] = $rem['title'];
    }

    // React Component Ingestion အတွက် သပ်ရပ်သော JSON Response ပြန်ပေးခြင်း
    echo json_encode([
        "status" => "success",
        "processed" => $processed_tasks
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "System Error: " . $e->getMessage()
    ]);
}
?>