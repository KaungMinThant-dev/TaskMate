<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['id'])) {
    $id = intval($data['id']);

    // ဒေတာဘေ့စ်ထဲမှာ အောင်မြင်စွာ စာဖတ်ပြီးမြောက်ကြောင်း (is_completed = 1) သွားပြင်မယ်
    $query = "UPDATE study_planner SET is_completed = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt->execute([$id])) {
        echo json_encode(["status" => "success", "message" => "Status updated to completed"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update status"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing Event ID"]);
}
?>