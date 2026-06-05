<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['user_id']) && !empty($data['subject_name'])) {
    $user_id = intval($data['user_id']);
    $subject_name = $data['subject_name'];
    $instructor_name = $data['instructor_name'];
    $days = $data['days'];
    $time_range = $data['time_range'];
    $color_code = $data['color_code'];

    $query = "INSERT INTO subjects (user_id, subject_name, instructor_name, days, time_range, color_code) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute([$user_id, $subject_name, $instructor_name, $days, $time_range, $color_code])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    echo json_encode(["status" => "invalid_input"]);
}
?>