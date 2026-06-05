<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['id'])) {
    $id = intval($data['id']); 
    // is_deleted column ကို သုံးမနေတော့ဘဲ တိုက်ရိုက်ဖျက်လိုက်ပါမယ်
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo json_encode(["status" => "success", "message" => "Task deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting task!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No ID provided!"]);
}
?>