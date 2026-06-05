<?php
// CORS Header များ သတ်မှတ်ခြင်း (Frontend က ခေါ်သုံးလို့ရအောင်)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_connect.php';

// Frontend က ပို့လာတဲ့ JSON Data ကိုဖတ်ခြင်း
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->email) && !empty($data->password)) {
    $email = $data->email;
    $password = $data->password;

    // Database ထဲမှာ Email ရှိမရှိ စစ်ဆေးခြင်း
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Password မှန်မမှန် စစ်ဆေးခြင်း
        if(password_verify($password, $user['password'])) {
            
            // ၁။ နောက်ဆုံး Login ဝင်ထားတဲ့အချိန်ကို Update လုပ်ခြင်း
            $loginTime = date('Y-m-d H:i:s');
            $updateStmt = $conn->prepare("UPDATE users SET last_login = ? WHERE email = ?");
            $updateStmt->execute([$loginTime, $email]);

            // ၂။ အောင်မြင်တဲ့အတွက် Data အားလုံးကို Frontend ဆီ ပြန်ပို့ခြင်း
            echo json_encode([
                "status" => "success",
                "user_id" => $user['user_id'],
                "username" => $user['username'], // အမှန်ပြင်ထားတဲ့နေရာ
                "message" => "Login successful!",
                "role" => $user['role'],
                "email" => $user['email']
            ]);
            
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Incomplete data."]);
}
?>