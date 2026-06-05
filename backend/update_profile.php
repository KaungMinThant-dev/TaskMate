<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if($data && isset($data->old_email)) {
    try {
        if (!empty($data->password)) {
            $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$data->username, $data->email, $hashedPassword, $data->old_email]);
        } else {
            $sql = "UPDATE users SET username = ?, email = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$data->username, $data->email, $data->old_email]);
        }
        echo json_encode(["status" => "success"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>