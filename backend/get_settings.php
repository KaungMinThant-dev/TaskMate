<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
$conn = new mysqli("localhost", "root", "", "taskmate_db");

$result = $conn->query("SELECT * FROM system_settings");
$settings = [];
while($row = $result->fetch_assoc()) {
    $settings[$row['config_key']] = $row['config_value'];
}
echo json_encode($settings);
?>