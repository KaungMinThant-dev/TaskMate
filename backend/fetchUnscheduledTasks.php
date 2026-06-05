<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php'; 

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    // သင့်မှာရှိပြီးသား tasks table ထဲက မပြီးသေးတဲ့ Task တွေကို ဘာသာရပ်အရောင်နဲ့တကွ ဆွဲထုတ်မယ်
    // (ማရီယာဒစ်ဘီ/MySQL ထဲက သင့် tasks table ရဲ့ တကယ့် column နာမည်တွေအတိုင်း လိုအပ်ရင် ပြင်ပေးပါ)
    $query = "SELECT t.*, s.subject_name, s.color_code 
              FROM tasks t 
              JOIN subjects s ON t.subject_id = s.id 
              WHERE t.user_id = ? AND t.status != 'completed'
              ORDER BY t.id DESC";
              
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
}
?>