<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php'; // သင့် database connection ဖိုင်

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if (!$user_id) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid or missing User ID"]);
    exit;
}

try {
    // အမှားပြင်ချက်: id နေရာမှာ user_id ကို ပြောင်းပေးလိုက်ပါပြီ
    $stmt = $conn->prepare("SELECT username, email, profile_image FROM users WHERE user_id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}
?>