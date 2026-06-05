<?php
header("Access-Control-Allow-Origin: *");
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $email = $_POST['email'];
    $fileName = time() . '_' . $_FILES['image']['name'];
    $targetFile = 'uploads/' . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $sql = "UPDATE users SET profile_image = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$fileName, $email]);
        echo json_encode(["status" => "success"]);
    }
}
?>