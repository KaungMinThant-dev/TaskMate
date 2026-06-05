<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

// $data->user_id ဖြစ်နေကြောင်း သေချာပါစေ (Frontend ကပို့တဲ့အတိုင်း)
if(isset($data->user_id)) {
    $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$data->username, $data->email, $data->role, $data->user_id]);
    
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "user_id not found"]);
}
?>