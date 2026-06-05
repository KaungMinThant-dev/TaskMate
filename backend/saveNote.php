<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$note_id = isset($data['id']) ? intval($data['id']) : 0;
$subject_id = !empty($data['subject_id']) ? intval($data['subject_id']) : null;
$title = isset($data['title']) ? trim($data['title']) : '';
$content = isset($data['content']) ? trim($data['content']) : '';

if ($user_id > 0) {
    if ($note_id > 0) {
        // 🌟 တကယ်လို့ ID ပါရင် Auto-Save (Update) လုပ်မယ်
        $query = "UPDATE notes SET subject_id = ?, title = ?, content = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$subject_id, $title, $content, $note_id, $user_id]);
        echo json_encode(["status" => "success", "message" => "Note auto-saved", "id" => $note_id]);
    } else {
        // 🌟 ID မပါရင် Note အသစ်ဆောက်မယ် (Insert)
        $query = "INSERT INTO notes (user_id, subject_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $subject_id, $title, $content]);
        $new_id = $conn->lastInsertId();
        echo json_encode(["status" => "success", "message" => "Note created successfully", "id" => $new_id]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid User Data"]);
}
?>