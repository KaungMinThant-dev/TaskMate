<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$subject_id = isset($data['subject_id']) ? intval($data['subject_id']) : 0;

if ($subject_id > 0) {
    // အဲဒီ Subject ကို ဖျက်ခြင်း
    $query = "DELETE FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$subject_id]);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>