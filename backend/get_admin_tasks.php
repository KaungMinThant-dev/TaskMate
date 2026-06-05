<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db_connect.php';

// LEFT JOIN သုံးပြီး Username ကို ဆွဲထုတ်ခြင်း
$query = "SELECT t.id as task_id, 
                 t.user_id, 
                 u.username, 
                 t.task_name as title, 
                 t.status, 
                 t.created_at, 
                 t.finished_at 
          FROM tasks t 
          LEFT JOIN users u ON t.user_id = u.user_id 
          WHERE t.is_deleted = 0 
          ORDER BY t.id DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);
?>