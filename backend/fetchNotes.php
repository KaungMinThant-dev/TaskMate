<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    $response = [];

    // (က) စာစုအားလုံးကို ဆွဲထုတ်ခြင်း (Pin ထိုးထားတာကို ထိပ်ဆုံးတင်ပြီး နောက်ဆုံးပြင်ဆင်တာကို အရင်ပြမည်)
    $q1 = "SELECT n.*, s.subject_name, s.color_code 
           FROM notes n 
           LEFT JOIN subjects s ON n.subject_id = s.id 
           WHERE n.user_id = ? 
           ORDER BY n.is_pinned DESC, n.updated_at DESC";
    $stmt1 = $conn->prepare($q1);
    $stmt1->execute([$user_id]);
    $response['notes'] = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // (ခ) ဘာသာရပ်အလိုက် Dynamic Note အရေအတွက်ကို တွက်ချက်ခြင်း (Folders Sidebar အတွက်)
    $q2 = "SELECT s.id, s.subject_name, s.color_code, COUNT(n.id) as note_count 
           FROM subjects s 
           LEFT JOIN notes n ON s.id = n.subject_id AND n.user_id = ?
           WHERE s.user_id = ?
           GROUP BY s.id";
    $stmt2 = $conn->prepare($q2);
    $stmt2->execute([$user_id, $user_id]);
    $response['folders'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
}
?>