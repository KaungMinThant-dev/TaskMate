<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$action = isset($data['action']) ? $data['action'] : '';

if ($user_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
    exit();
}

try {
    switch ($action) {
        case 'update_profile':
            $full_name = isset($data['full_name']) ? trim($data['full_name']) : '';
            $student_id = isset($data['student_id']) ? trim($data['student_id']) : '';
            $bio = isset($data['bio']) ? trim($data['bio']) : '';
            $study_year = isset($data['study_year']) ? trim($data['study_year']) : '1st Year';

            // 🌟 WHERE user_id = ? ဖြစ်ကြောင်း သေချာစေရမည်
            $query = "UPDATE users SET full_name = ?, student_id = ?, bio = ?, study_year = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$full_name, $student_id, $bio, $study_year, $user_id]);
            echo json_encode(["status" => "success", "message" => "Profile updated successfully!"]);
            break;

        case 'update_timer':
            $focus_time = isset($data['focus_time']) ? intval($data['focus_time']) : 25;
            $break_time = isset($data['break_time']) ? intval($data['break_time']) : 5;
            $alarm_sound = isset($data['alarm_sound']) ? trim($data['alarm_sound']) : 'classic_bell';

            // 🌟 ဤနေရာတွင်လည်း WHERE user_id = ? ဟု ကွက်တိပြောင်းလဲထားပါသည်
            $query = "UPDATE users SET focus_time = ?, break_time = ?, alarm_sound = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$focus_time, $break_time, $alarm_sound, $user_id]);
            echo json_encode(["status" => "success", "message" => "Timer preferences saved!"]);
            break;

        case 'update_security':
            $current_pass = isset($data['current_password']) ? $data['current_password'] : '';
            $new_pass = isset($data['new_password']) ? $data['new_password'] : '';

            // 🌟 Nested IF စနစ်ဖြင့် ရေးသားထားသဖြင့် VS Code လိုင်းနီလည်း ပြတော့မည်မဟုတ်ပါ
            $chk_query = "SELECT password FROM users WHERE user_id = ?";
            $chk_stmt = $conn->prepare($chk_query);
            $chk_stmt->execute([$user_id]);
            $user = $chk_stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($current_pass, $user['password'])) {
                    $hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                    $up_query = "UPDATE users SET password = ? WHERE user_id = ?";
                    $up_stmt = $conn->prepare($up_query);
                    $up_stmt->execute([$hashed_pass, $user_id]);
                    echo json_encode(["status" => "success", "message" => "Password changed successfully!"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Incorrect current password!"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "User not found!"]);
            }
            break;

        case 'update_preferences':
            $theme_mode = isset($data['theme_mode']) ? trim($data['theme_mode']) : 'light';

            // 🌟 ဤနေရာတွင်လည်း WHERE user_id = ? ဟု ကွက်တိပြင်ဆင်ထားပါသည်
            $query = "UPDATE users SET theme_mode = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$theme_mode, $user_id]);
            echo json_encode(["status" => "success", "message" => "Preferences saved!"]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Invalid Action"]);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database Update SQL Error: " . $e->getMessage()]);
}
?>