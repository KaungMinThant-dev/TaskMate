<?php
// 🌟 ၁။ CORS Policy Settings အား အပြည့်အဝ ခွင့်ပြုပေးခြင်း
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
include 'db_connect.php';

// Frontend မှ ပေးပို့လိုက်သော JSON Command အား ဖတ်ယူခြင်း
$data = json_decode(file_get_contents("php://input"), true);
$command = isset($data['command']) ? trim($data['command']) : '';

if (empty($command)) {
    echo json_encode(["status" => "error", "message" => "Please enter a valid command."]);
    exit();
}

$command_lower = strtolower($command);
$words = explode(" ", $command);
$target_username = end($words); 

$target_type = null;
$action_type = 'fetch_info'; 

// Command အမျိုးအစားခွဲခြားခြင်း Logic
if (strpos($command_lower, 'acc type') !== false || strpos($command_lower, 'check') !== false) {
    $action_type = 'quick_check_status';
} elseif (strpos($command_lower, 'premium') !== false) {
    $target_type = 'premium';
    $action_type = 'update_status';
} elseif (strpos($command_lower, 'free') !== false) {
    $target_type = 'free';
    $action_type = 'update_status';
} else {
    $action_type = 'fetch_info';
}

if ($target_username) {
    try {
        // ==========================================================================
        // 🛡️ 🌟 MASTER SQL JOIN ENGINE: Users ရော Premium Requests ပါ ပြိုင်တူဆွဲထုတ်ခြင်း
        // ==========================================================================
        $checkStmt = $conn->prepare("
            SELECT u.user_id, u.username, u.full_name, u.email, u.role, u.account_type,
                   p.payment_method, p.transaction_id, p.status AS request_status
            FROM users u
            LEFT JOIN premium_requests p ON u.user_id = p.user_id
            WHERE u.username = ?
            ORDER BY p.user_id DESC LIMIT 1
        ");
        $checkStmt->execute([$target_username]);
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $db_acc_type = strtolower($user['account_type']);
            if ($db_acc_type === 'normal' || $db_acc_type === '') { $db_acc_type = 'free'; }

            // 🛡️ SECURITY GUARD 1: Premium အဆင့်မြှင့်ရန် ကြိုးစားချိန်တွင် ၎င်း User သည် Pending ဖြစ်မနေပါက တားဆီးခြင်း
            if ($target_type === 'premium' && $db_acc_type !== 'pending') {
                echo json_encode([
                    "status" => "error", 
                    "message" => "Security Access Denied: @{$target_username} cannot be upgraded to Premium because they have not submitted a payment request (Status is currently {$db_acc_type})."
                ]);
                exit();
            }

            // ==========================================================================
            // 🤖 DYNAMIC BOT TELEMETRY: Bot မျက်နှာပြင်တွင် ပေါ်မည့် စာသားအသေးစိတ်အား တည်ဆောက်ခြင်း
            // ==========================================================================
            $display_amount = 5000; // Premium Default Price
            $payment_info = "";
            $raw_payment_log = "None";
            
            if (!empty($user['transaction_id'])) {
                $payment_info = " | Method: " . strtoupper($user['payment_method']) . 
                                " | Amt: " . number_format($display_amount) . " MMK" .
                                " | TxID: " . $user['transaction_id'] . 
                                " [Req: " . strtoupper($user['request_status']) . "]";
                
                $raw_payment_log = strtoupper($user['payment_method']) . " (TxID: " . $user['transaction_id'] . ")";
            }

            $final_message_details = "User: " . $user['username'] . " | Status: " . strtoupper($target_type ? $target_type : $db_acc_type) . $payment_info;

            // Admin Bot UI ကောင်တာဆီသို့ သန့်ရှင်းစင်ကြယ်သော Response ဒေတာ ပြန်လည်ပေးပို့ခြင်း
            echo json_encode([
                "status" => "success",
                "action_type" => $action_type, 
                "data" => [
                    "user_id" => $user['user_id'],
                    "username" => $user['username'],
                    "full_name" => $user['full_name'],
                    "email" => $user['email'],
                    "role" => $user['role'],
                    "account_type" => $target_type ? $target_type : $db_acc_type,
                    "message_details" => $final_message_details
                ]
            ]);

            // ==========================================================================
            // 🚀 🌟 TELEGRAM ADMIN OPERATIONAL AUDIT LOG (၁၀၀% Real Chat ID Fixed)
            // ==========================================================================
            // Admin က Web UI ပေါ်မှာ Check လုပ်လိုက်တိုင်း သင့် Telegram ဆီသို့ပါ သက်သေအဖြစ် လှမ်းပို့ပေးမည့် Audit Engine
            if ($action_type === 'quick_check_status') {
                $telegram_token = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE"; 
                $chat_id = "1810378199"; // 👈 အောင်မြင်စွာ ရှာဖွေတွေ့ရှိခဲ့သော စစ်မှန်သည့် Chat ID 

                $audit_message = "🔍 <b>[Admin Audit Alert]</b> 🔍\n\n";
                $audit_message .= "👨‍💻 <b>Action:</b> Admin queried student logs.\n";
                $audit_message .= "👤 <b>Target Student:</b> @{$user['username']}\n";
                $audit_message .= "📊 <b>Current Status:</b> " . strtoupper($db_acc_type) . "\n";
                $audit_message .= "💳 <b>Payment Log:</b> <code>{$raw_payment_log}</code>\n\n";
                $audit_message .= "⚡ <i>Audit telemetry logged successfully via TaskMate Agent.</i>";

                $telegram_params = http_build_query([
                    'chat_id' => $chat_id,
                    'text' => $audit_message,
                    'parse_mode' => 'HTML'
                ]);

                $url = "https://api.telegram.org/bot" . $telegram_token . "/sendMessage?" . $telegram_params;
                
                $stream_options = [
                    "ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ],
                    "http" => [
                        "timeout" => 3
                    ]
                ];
                
                $context = stream_context_create($stream_options);
                @file_get_contents($url, false, $context);
            }
            // ==========================================================================

        } else {
            echo json_encode(["status" => "error", "message" => "Username '{$target_username}' not found in database!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid command format!"]);
}
?>