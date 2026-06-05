<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connect.php'; 

$data = json_decode(file_get_contents("php://input"), true);

$task_name = isset($data['task_name']) ? trim($data['task_name']) : '';
$user_id = isset($data['user_id']) ? intval($data['user_id']) : null;
$priority = isset($data['priority']) ? $data['priority'] : 'Medium';
$deadline = !empty($data['deadline']) ? $data['deadline'] : null; 
$deadline_time = !empty($data['deadline_time']) ? $data['deadline_time'] : '09:00:00';

// Frontend က ပို့လိုက်တဲ့ subject_id ကို ဖမ်းယူခြင်း (မရွေးထားရင် null ဖြစ်မယ်)
$subject_id = !empty($data['subject_id']) ? intval($data['subject_id']) : null;

if (empty($task_name) || empty($user_id)) {
    echo json_encode(["status" => "error", "message" => "Error: Missing data!"]);
    exit; 
}

try {
    // Column နာမည်ကို `task_name` လို့ သေချာအောင် သုံးထားပြီး ? နေရာတွေနဲ့ Execute parameter တွေကို အစီအစဉ်အတိုင်း ညှိထားပါတယ်
    $query = "INSERT INTO tasks (task_name, user_id, priority, deadline_date, deadline_time, status, subject_id, created_at) 
              VALUES (?, ?, ?, ?, ?, 'Pending', ?, NOW())";
              
    $stmt = $conn->prepare($query);
    
    // Execute ထဲက Variables အစီအစဉ်ဟာ အပေါ်က SQL (?) အစီအစဉ်အတိုင်း ကွက်တိတူရပါမယ်
    $stmt->execute([$task_name, $user_id, $priority, $deadline, $deadline_time, $subject_id]);
    
    echo json_encode(["status" => "success", "message" => "Task added successfully!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
}
?>