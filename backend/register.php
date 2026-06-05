<?php
// register.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connect.php';

// Get data from the frontend
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->email) && !empty($data->password)) {

    $username = trim($data->username);
    $email = trim($data->email);
    $password = $data->password;

    // 1. Email Validation (Structure and Domain check)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        echo json_encode(["message" => "Invalid email format!"]);
        exit;
    }

    // 2. Password Validation
    if (strlen($password) < 6) {
        echo json_encode(["message" => "Password must be at least 6 characters long."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();
        echo json_encode(["message" => "Registration successful!"]);

    } catch(PDOException $e) {
        // Handle database specific errors (like duplicate email)
        if ($e->getCode() == '23000') {
            echo json_encode(["message" => "This email is already registered. Please use another one."]);
        } else {
            echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
        }
    }

} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>