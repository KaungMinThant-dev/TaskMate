<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if($data && isset($data->old_email) && isset($data->new_email)) {
    // Email အသစ်က တခြားသူတွေနဲ့ မတူကြောင်း အရင်စစ်ဆေးသင့်ပါတယ်
    $sql = "UPDATE users SET email = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$data->new_email, $data->old_email]);
    
    echo json_encode(["status" => "success", "message" => "Email updated"]);
}
?>