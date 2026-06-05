<?php
// 🌟 ၁။ CORS Policy Settings အား အပြည့်အဝ ခွင့်ပြုပေးခြင်း
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connect.php';

// Frontend မှ ပေးပို့လိုက်သော JSON Data များကို ဖတ်ယူခြင်း
$data = json_decode(file_get_contents("php://input"), true);

$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$payment_method = isset($data['payment_method']) ? trim($data['payment_method']) : '';
$transaction_id = isset($data['transaction_id']) ? trim($data['transaction_id']) : '';
$amount = isset($data['amount']) ? intval($data['amount']) : 5000; 

if ($user_id <= 0 || empty($payment_method) || empty($transaction_id)) {
    echo json_encode([
        "status" => "error", 
        "message" => "Validation Error: Incomplete payment fields received!"
    ]);
    exit();
}

try {
    // 🌟 ၂။ ဒေတာဘေ့စ် စံနှုန်းအတိုင်း သန့်ရှင်းစွာ Transaction မောင်းနှင်ခြင်း
    $conn->beginTransaction();

    $query1 = "INSERT INTO premium_requests (user_id, payment_method, transaction_id, status) VALUES (?, ?, ?, 'pending')";
    $stmt1 = $conn->prepare($query1);
    $stmt1->execute([$user_id, $payment_method, $transaction_id]);

    // 🔑 အသစ်ဝင်သွားသော Request ၏ ID အား Inline Button အတွက် လှမ်းယူခြင်း
    $requestId = $conn->lastInsertId(); 

    $query2 = "UPDATE users SET account_type = 'pending' WHERE user_id = ?"; 
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute([$user_id]);

    $userQuery = "SELECT username FROM users WHERE user_id = ?";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->execute([$user_id]);
    $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
    $username = $userRow ? $userRow['username'] : 'Unknown User';

    $conn->commit();

    // ==========================================================================
    // ⚡ 🌟 FAST FRONTEND RESPONSE (၁၀၀% CRASH PROOF)
    // ==========================================================================
    echo json_encode(["status" => "success", "message" => "Your request is submitted and pending approval!"]);
    
    // ကျောင်းသားမျက်နှာပြင်ကို Loading လည်မနေစေရန် Response အရင်ထုတ်ပေးပြီး Server Connection ဖြတ်ချခြင်း
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request(); 
    } else {
        ob_end_flush();
        flush(); 
    }
    // ==========================================================================

    // ==========================================================================
    // 🚀 🌟 TELEGRAM REAL-TIME BACKGROUND ENGINE (INLINE KEYBOARD BUTTONS VERSION)
    // ==========================================================================
    $telegram_token = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE"; 
    $chat_id = "1810378199";                     

    $message = "👑 <b>[TaskMate Premium Request]</b> 👑\n\n";
    $message .= "👤 <b>Student:</b> @{$username} (ID: #{$user_id})\n";
    $message .= "💰 <b>Amount:</b> " . number_format($amount) . " MMK\n";
    $message .= "💳 <b>Method:</b> {$payment_method}\n";
    $message .= "🔑 <b>TxID (6 Digits):</b> <code>{$transaction_id}</code>\n\n";
    $message .= "⚡ <i>Choose an action directly below:</i>";

    // 🎛️ Inline Keyboard Buttons (Callback Data ထဲတွင် Request ID နှင့် User ID အား ခွဲခြားပို့ဆောင်ခြင်း)
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '✅ Approve', 'callback_data' => "approve_{$requestId}_{$user_id}"],
                ['text' => '❌ Decline', 'callback_data' => "decline_{$requestId}_{$user_id}"]
            ]
        ]
    ];

    $url = "https://api.telegram.org/bot" . $telegram_token . "/sendMessage";
    
    // cURL ပို့ရန် ဒေတာများကို Array ပုံစံ ပြင်ဆင်ခြင်း
    $telegram_payload = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML',
        'reply_markup' => json_encode($keyboard)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($telegram_payload));
    
    // 🛡️ Extra Localhost Proxy Bypass Options (Windows XAMPP အတွက် အသက်ချက်ပါဗျာ)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");

    curl_exec($ch);
    curl_close($ch);
    // ==========================================================================

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
}
?>