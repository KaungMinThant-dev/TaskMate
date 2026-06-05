<?php
// CORS Header များ သတ်မှတ်ခြင်း
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$conn = new mysqli("localhost", "root", "", "taskmate_db");

$data = json_decode(file_get_contents("php://input"), true);
$key = $data['config_key'];
$value = $data['config_value'];

$conn->query("UPDATE system_settings SET config_value = '$value' WHERE config_key = '$key'");
echo json_encode(["message" => "Settings updated"]);
?>