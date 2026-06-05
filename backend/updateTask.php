<?php
// CORS Header များ
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Preflight request ကို handle လုပ်ပါ
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

$conn = new mysqli("localhost", "root", "", "taskmate_db");

if ($conn->connect_error) {
    echo json_encode(["message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$raw_data = file_get_contents("php://input");
$data = json_decode($raw_data, true);

if ($data && isset($data['id'])) {
    $id = $data['id'];

    /* SQL Logic: 
       - status က Pending ဆိုရင် Completed ပြောင်းမယ်၊ finished_at မှာ အခုအချိန် (NOW) ထည့်မယ်။
       - status က Completed ဆိုရင် Pending ပြောင်းမယ်၊ finished_at ကို NULL ပြန်လုပ်မယ်။
    */
   
       // updateTask.php အတွက် ပြင်ဆင်ချက်
$stmt = $conn->prepare("UPDATE tasks 
                        SET finished_at = IF(status = 'Pending', NOW(), NULL),
                            status = IF(status = 'Pending', 'Completed', 'Pending')
                        WHERE id = ?");
                        
    
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo json_encode(["message" => "Task updated successfully!"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid request: No ID provided."]);
}

$conn->close();
?>