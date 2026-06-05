<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// သင့် database connection file နာမည် (db_connect.php သို့မဟုတ် connection.php) သေချာစစ်ထည့်ပါ
include 'db_connect.php'; 

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    // Subject တစ်ခုချင်းစီရဲ့ Pending Tasks အရေအတွက်ကို တစ်ခါတည်း တွက်ထုတ်မယ့် SQL Query
    $query = "SELECT s.*, 
              COUNT(CASE WHEN t.status = 'Pending' THEN 1 END) as pending_tasks 
              FROM subjects s 
              LEFT JOIN tasks t ON s.id = t.subject_id 
              WHERE s.user_id = ? 
              GROUP BY s.id 
              ORDER BY s.id DESC";
              
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($subjects);
} else {
    echo json_encode([]);
}
?>