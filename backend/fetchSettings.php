<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    try {
        // 🌟 WHERE id = ? နေရာတွင် WHERE user_id = ? ဟု ပြင်ဆင်ထားပါသည်
        $query = "SELECT * FROM users WHERE user_id = ?";

        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            echo json_encode(["status" => "success", "data" => $user_data]);
        } else {
            echo json_encode(["status" => "error", "message" => "User not found in database."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database SQL Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
}
?>