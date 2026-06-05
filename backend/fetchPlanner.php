<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// သင့် db connection file နာမည်အတိုင်း ပြင်ပေးပါ (ဥပမာ- db_connect.php သို့မဟုတ် config.php)
include 'db_connect.php'; 

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    // study_planner ထဲက ဒေတာကို ဆွဲထုတ်ရင်း ဘာသာရပ်ရဲ့ color_code ကိုပါ တစ်ခါတည်း တွဲယူမယ်
    $query = "SELECT p.*, s.color_code, s.subject_name 
              FROM study_planner p 
              LEFT JOIN subjects s ON p.subject_id = s.id 
              WHERE p.user_id = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
}
?>