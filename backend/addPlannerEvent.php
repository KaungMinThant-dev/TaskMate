<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['user_id']) && !empty($data['subject_id']) && !empty($data['task_name'])) {
    $user_id = intval($data['user_id']);
    $subject_id = intval($data['subject_id']);
    $task_name = $data['task_name'];
    
    // FullCalendar က ပို့ပေးတဲ့ ISO အချိန်ပုံစံကို MySQL DATETIME ပုံစံပြောင်းလဲခြင်း
    $start_time = date('Y-m-d H:i:s', strtotime($data['start_time']));
    $end_time = date('Y-m-d H:i:s', strtotime($data['end_time']));

    $query = "INSERT INTO study_planner (user_id, subject_id, task_name, start_time, end_time, is_completed) 
              VALUES (?, ?, ?, ?, ?, 0)";
              
    $stmt = $conn->prepare($query);
    if ($stmt->execute([$user_id, $subject_id, $task_name, $start_time, $end_time])) {
        echo json_encode(["status" => "success", "message" => "Event added to planner successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save event"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Incomplete Data Input"]);
}
?>