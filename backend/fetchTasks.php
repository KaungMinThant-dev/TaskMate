<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;

if ($user_id > 0) {
    if ($subject_id > 0) {
        // [အဓိကပြင်ဆင်ချက်] Subjects Page ကလာရင် အဲဒီ User ရဲ့ 'Pending' ဖြစ်တဲ့ Task တွေကိုပဲ စစ်ထုတ်ပြမည်
        $query = "SELECT * FROM tasks WHERE user_id = ? AND subject_id = ? AND status = 'Pending' ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $subject_id]);
    } else {
        // သာမန်အတိုင်း Dashboard/Tasks စာမျက်နှာမှာတော့ လက်ရှိ User တစ်ဦးတည်းရဲ့ Tasks အကုန်လုံးကိုပြမည်
        $query = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
    }
    
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
} else {
    echo json_encode([]);
}
?>