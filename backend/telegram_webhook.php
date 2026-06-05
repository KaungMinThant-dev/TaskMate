<?php
// 🛠️ telegram_webhook.php
include 'db_connect.php';

$telegram_token = "8694979672:AAEzV-yYCl51TCU2aD356_1d4VjLZ9vzwzE";

// Telegram မှ ပို့လိုက်သော Webhook JSON ဒေတာအား ဖတ်ယူခြင်း
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// 🖱️ Inline Button နှိပ်ခြင်း ဟုတ်မဟုတ် စစ်ဆေးခြင်း
if (isset($update['callback_query'])) {
    $callbackQuery = $update['callback_query'];
    $data = $callbackQuery['data']; // ရလဒ်ပုံစံ: "approve_ID_UserID"
    $chatId = $callbackQuery['message']['chat']['id'];
    $messageId = $callbackQuery['message']['message_id'];

    // Callback Data အား ခွဲထုတ်ခြင်း
    $parts = explode('_', $data);
    $action = $parts[0];    // approve သို့မဟုတ် decline
    $reqId = $parts[1];     // Premium Request ID
    $userId = $parts[2];    // User ID

    try {
        $conn->beginTransaction();

        if ($action === 'approve') {
            // ၁။ Premium Requests Table ကို status = 'approved' ပြောင်းခြင်း
            $stmt1 = $conn->prepare("UPDATE premium_requests SET status = 'approved' WHERE id = ?");
            $stmt1->execute([$reqId]);

            // ၂။ Users Table တွင် account_type = 'premium' ပြောင်းပေးခြင်း
            $stmt2 = $conn->prepare("UPDATE users SET account_type = 'premium' WHERE user_id = ?");
            $stmt2->execute([$userId]);

            $responseText = "<b>✅ [TaskMate Premium Approved]</b>\n\n";
            $responseText .= "🎯 <b>Request ID:</b> #{$reqId}\n";
            $responseText .= "👤 <b>User ID:</b> #{$userId}\n\n";
            $responseText .= "🚀 <i>Status: Database updated successfully. User is now Premium!</i>";
        } 
        else if ($action === 'decline') {
            // Declined ဖြစ်ပါက Request Status အား ငြင်းပယ်ခြင်း၊ User အား Normal ပြန်ပြောင်းခြင်း
            $stmt1 = $conn->prepare("UPDATE premium_requests SET status = 'declined' WHERE id = ?");
            $stmt1->execute([$reqId]);

            $stmt2 = $conn->prepare("UPDATE users SET account_type = 'free' WHERE user_id = ?");
            $stmt2->execute([$userId]);

            $responseText = "<b>❌ [TaskMate Premium Declined]</b>\n\n";
            $responseText .= "🎯 <b>Request ID:</b> #{$reqId}\n";
            $responseText .= "👤 <b>User ID:</b> #{$userId}\n\n";
            $responseText .= "⚠️ <i>Status: Request declined. User reverted to Free account.</i>";
        }

        $conn->commit();

    } catch (PDOException $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $responseText = "❌ <b>Database Error:</b> " . $e->getMessage();
    }

    // 🔄 Telegram ပေါ်ရှိ မူရင်းစာသားအား အတည်ပြုစာသားအဖြစ် ပြန်လည်ပြင်ဆင်ရေးသားခြင်း (ခလုတ်များ ဖြုတ်ပစ်မည်)
    $editUrl = "https://api.telegram.org/bot" . $telegram_token . "/editMessageText";
    $edit_data = http_build_query([
        'chat_id' => $chatId,
        'message_id' => $messageId,
        'text' => $responseText,
        'parse_mode' => 'HTML'
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $editUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $edit_data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($ch);
    curl_close($ch);
    
    // 🔔 Telegram Loading စက်ဝိုင်းလေး ရပ်တန့်သွားစေရန် answerCallbackQuery ခေါ်ခြင်း
    $answerUrl = "https://api.telegram.org/bot" . $telegram_token . "/answerCallbackQuery?callback_query_id=" . $callbackQuery['id'];
    
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $answerUrl);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($ch2);
    curl_close($ch2);
}
?>