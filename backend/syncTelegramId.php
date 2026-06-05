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

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

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

// Ingest Asynchronous Axios JSON Payload Request From React
$data = json_decode(file_get_contents("php://input"), true);
$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid User ID Specification."]);
    exit();
}

try {
    $telegram_token = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE";
    // ကန့်သတ်ချက်မရှိ စာလှမ်းဖတ်ရန် Dynamic Polling ဖွင့်ခြင်း (Offset=-1 Strategy)
    $url = "https://api.telegram.org/bot" . $telegram_token . "/getUpdates?offset=-1&limit=10";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $debug_info = [
        "current_logged_in_web_user" => $user_id,
        "telegram_raw_response" => null,
        "found_match" => false
    ];

    if ($response) {
        $tele_data = json_decode($response, true);
        $debug_info["telegram_raw_response"] = $tele_data;
        
        if (isset($tele_data['result']) && is_array($tele_data['result']) && !empty($tele_data['result'])) {
            foreach ($tele_data['result'] as $update) {
                $msg_node = isset($update['message']) ? $update['message'] : (isset($update['edited_message']) ? $update['edited_message'] : null);
                
                if ($msg_node && isset($msg_node['text'])) {
                    $text = trim($msg_node['text']); // ဝင်လာသော စာသား
                    $chat_id = $msg_node['from']['id']; // ကျောင်းသား၏ Telegram Chat ID

                    // 🕵️‍♂️ 🌟 DYNAMIC REGEX: Telegram Link Parameter ထဲက ဘယ် User ID ဂဏန်းမဆို ဆွဲထုတ်ခြင်း
                    if (preg_match('/\/start\s+(\d+)/', $text, $matches)) {
                        $extracted_user_id = intval($matches[1]); 

                        // 🎯 Web က တောင်းဆိုနေတဲ့ User ID နှင့် Telegram ထဲက Inbound ID ကွက်တိ ကိုက်ညီသွားပါက
                        if ($extracted_user_id === $user_id) {
                            
                            $debug_info["found_match"] = true;
                            $debug_info["synchronized_id"] = $extracted_user_id;

                            // Dynamic Update Loop: သက်ဆိုင်ရာ $user_id ရဲ့ ကွက်လပ်ထဲသို့သာ တည့်တည့်သွားသိမ်းခြင်း
                            $query = "UPDATE users SET telegram_chat_id = ? WHERE user_id = ?";
                            $updateStmt = $conn->prepare($query);
                            $updateStmt->execute([$chat_id, $user_id]);

                            echo json_encode([
                                "status" => "success", 
                                "message" => "Telegram link successfully established for User ID: " . $user_id,
                                "telegram_chat_id" => $chat_id,
                                "debug" => $debug_info
                            ]);
                            exit();
                        }
                    }
                }
            }
        }
    }

    echo json_encode([
        "status" => "pending", 
        "message" => "Waiting for Deep Linking verification...",
        "debug" => $debug_info
    ]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>