<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid User ID."]);
    exit();
}

try {
    // ✅ 'id AS subject_id' ဟု ပြောင်းလဲလိုက်သဖြင့် Database ထဲရှိ id အား React ဘက်သို့ ကွက်တိ ချိတ်ဆက်ပေးမည်ဖြစ်သည်
    $query = "SELECT id AS subject_id, subject_name FROM subjects WHERE user_id = ? ORDER BY subject_name ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "data" => $subjects
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database Error: " . $e->getMessage()
    ]);
}
?>