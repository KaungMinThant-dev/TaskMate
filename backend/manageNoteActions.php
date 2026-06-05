<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$action = isset($data['action']) ? $data['action'] : '';
$note_id = isset($data['id']) ? intval($data['id']) : 0;

if ($note_id > 0) {
    if ($action === 'delete') {
        $query = "DELETE FROM notes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$note_id]);
        echo json_encode(["status" => "success", "message" => "Note deleted"]);
    } elseif ($action === 'toggle_pin') {
        // Pin တန်ဖိုးကို 0 ဖြစ်နေရင် 1 ပြောင်း၊ 1 ဖြစ်နေရင် 0 ပြောင်းပေးခြင်း
        $query = "UPDATE notes SET is_pinned = NOT is_pinned WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$note_id]);
        echo json_encode(["status" => "success", "message" => "Pin status toggled"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>