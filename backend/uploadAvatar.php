<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

if ($user_id > 0 && isset($_FILES['avatar'])) {
    $target_dir = "uploads/";
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
    $new_file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        try {
            // 🌟 WHERE user_id = ? ဟု စိတ်ချရအောင် ပြင်ဆင်ထားပါသည်
            $query = "UPDATE users SET avatar = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$new_file_name, $user_id]);

            echo json_encode(["status" => "success", "message" => "Avatar uploaded successfully!", "avatar" => $new_file_name]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "SQL Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to write file to uploads/ directory."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Data or File missing."]);
}
?>