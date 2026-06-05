<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if($data && isset($data->id)) {
    $sql = "UPDATE users SET is_deleted = 1 WHERE user_id = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->execute([$data->id]);
    echo json_encode(["status" => "success"]);
}
?>