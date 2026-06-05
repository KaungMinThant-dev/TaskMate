<?php
// submit_bug.php - TaskMate Enterprise Automated Bug Telemetry Real-Time Routing Engine

/* ==========================================================================
   🚨 1. CORS BYPASS SYSTEM (Browser Web Block Matrix)
   ========================================================================== */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");

// React Preflight Handshake (OPTIONS) ခွင့်ပြုချက်ချက်ချင်းပေးခြင်း
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

/* ==========================================================================
   📦 2. INPUT DECODER & STRUCTURAL CLEANING (ဒေတာ လက်ခံခြင်း)
   ========================================================================== */
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!isset($data['category']) || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error", 
        "message" => "Malformed input parameters array."
    ]);
    exit;
}

$category = htmlspecialchars($data['category']);
$bugMessage = htmlspecialchars($data['message']);
$timestamp = date('Y-m-d H:i:s');
$simulatedLogId = "BUG-" . rand(1000, 9999);

/* ==========================================================================
   🤖 3. TELEGRAM CHANNELS CONFIGURATION (ခင်ဗျားရဲ့ API ကြိုးများ ချိတ်ဆက်ခြင်း)
   ========================================================================== */
// ကိုကောင်းမင်းသန့် ပေးထားသော Bot Token နှင့် Personal User ID အမှန်များကို Lock ချိတ်ဆက်ပေးထားပါသည်
$botToken = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE"; 
$chatId = "1810378199";   

// Premium SaaS Style HTML Message Format
$telegramText = "🚨 <b>[TASKMATE BUG TELEMETRY DETECTED]</b> 🚨\n\n";
$telegramText .= "🆔 <b>Log ID:</b> <code>{$simulatedLogId}</code>\n";
$telegramText .= "🎯 <b>Boundary Layer:</b> <code>{$category}</code>\n";
$telegramText .= "⏱️ <b>Timestamp:</b> <code>{$timestamp}</code>\n\n";
$telegramText .= "📝 <b>Exception Trace Message:</b>\n<i>\"{$bugMessage}\"</i>\n\n";
$telegramText .= "⚡ <i>Action Required: Uplink active. Review MySQL instance.</i>";

$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";
$postFields = [
    'chat_id' => $chatId,
    'text' => $telegramText,
    'parse_mode' => 'HTML'
];

// PHP cURL Engine Automation
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

/* ==========================================================================
   🏁 4. RESPONSE DOCK TERMINAL (React Client API Feedback)
   ========================================================================== */
if ($curlError) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Telegram API Connectivity Drop: " . $curlError
    ]);
} else {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "log_id" => $simulatedLogId,
        "telegram_delivered" => true
    ]);
}