<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
include 'db_connect.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id > 0) {
    $response = [];

    // ==========================================
    // ၁။ SUMMARY CARDS အတွက် DATA တွက်ချက်ခြင်း
    // ==========================================
    
    // (က) ဒီအပတ် စုစုပေါင်း စာဖတ်ခဲ့သည့် နာရီပေါင်း (Study Planner မှ)
    $q1 = "SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) / 60 AS total_hours 
           FROM study_planner 
           WHERE user_id = ? AND is_completed = 1 AND YEARWEEK(start_time, 1) = YEARWEEK(CURDATE(), 1)";
    $stmt1 = $conn->prepare($q1);
    $stmt1->execute([$user_id]);
    $res1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $response['total_hours'] = $res1['total_hours'] ? round($res1['total_hours'], 1) : 0;

    // (ခ) Tasks Completion Rate (Tasks Table မှ ရာခိုင်နှုန်းတွက်ခြင်း)
    $q2 = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed 
           FROM tasks WHERE user_id = ?";
    $stmt2 = $conn->prepare($q2);
    $stmt2->execute([$user_id]);
    $res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    $total_tasks = intval($res2['total']);
    $completed_tasks = intval($res2['completed']);
    $response['completion_rate'] = $total_tasks > 0 ? round(($completed_tasks / $total_tasks) * 100) : 0;

    // (ဂ) Study Streak (ဒီအပတ်ထဲ စာဖတ်ဖြစ်သည့် ရက်ပေါင်းကို Streak အဖြစ် သတ်မှတ်ခြင်း)
    $q3 = "SELECT COUNT(DISTINCT DATE(start_time)) as streak 
           FROM study_planner 
           WHERE user_id = ? AND is_completed = 1 AND YEARWEEK(start_time, 1) = YEARWEEK(CURDATE(), 1)";
    $stmt3 = $conn->prepare($q3);
    $stmt3->execute([$user_id]);
    $res3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $response['streak'] = $res3['streak'] ? intval($res3['streak']) : 0;


    // ==========================================
    // ၂။ WEEKLY STUDY TREND (ရက်အလိုက် တိုင်ပြဇယားအတွက်)
    // ==========================================
    $q4 = "SELECT DAYNAME(start_time) as day_name, ROUND(SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time))/60, 1) as hours
           FROM study_planner
           WHERE user_id = ? AND is_completed = 1 AND YEARWEEK(start_time, 1) = YEARWEEK(CURDATE(), 1)
           GROUP BY DAYNAME(start_time)";
    $stmt4 = $conn->prepare($q4);
    $stmt4->execute([$user_id]);
    $res4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

    // ရက်တွေအကုန်လုံး 0h နဲ့ အရင် baseline ဆောက်ထားခြင်း (ဇယားကွက်မပျက်စေရန်)
    $week_days = ['Monday' => 0, 'Tuesday' => 0, 'Wednesday' => 0, 'Thursday' => 0, 'Friday' => 0, 'Saturday' => 0, 'Sunday' => 0];
    foreach ($res4 as $row) {
        $week_days[$row['day_name']] = floatval($row['hours']);
    }
    
    // Recharts သုံးရလွယ်အောင် Format ပြောင်းခြင်း
    $trend_data = [];
    $short_names = ['Monday'=>'Mon', 'Tuesday'=>'Tue', 'Wednesday'=>'Wed', 'Thursday'=>'Thu', 'Friday'=>'Fri', 'Saturday'=>'Sat', 'Sunday'=>'Sun'];
    foreach ($week_days as $full_name => $hours) {
        $trend_data[] = ['name' => $short_names[$full_name], 'hours' => $hours];
    }
    $response['weekly_trend'] = $trend_data;


    // ==========================================
    // ၃။ SUBJECT DISTRIBUTION (ဘာသာရပ်အလိုက် စက်ဝိုင်းဇယားအတွက်)
    // ==========================================
    $q5 = "SELECT s.subject_name as name, s.color_code as color, ROUND(SUM(TIMESTAMPDIFF(MINUTE, p.start_time, p.end_time))/60, 1) as hours
           FROM study_planner p
           JOIN subjects s ON p.subject_id = s.id
           WHERE p.user_id = ? AND p.is_completed = 1
           GROUP BY p.subject_id";
    $stmt5 = $conn->prepare($q5);
    $stmt5->execute([$user_id]);
    $res5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

    // ရာခိုင်နှုန်းတွက်ချက်ရန် စုစုပေါင်းနာရီ အရင်ရှာခြင်း
    $grand_hours = 0;
    foreach ($res5 as $row) { $grand_hours += $row['hours']; }

    $subject_data = [];
    foreach ($res5 as $row) {
        $percentage = $grand_hours > 0 ? round(($row['hours'] / $grand_hours) * 100) : 0;
        $subject_data[] = [
            'name' => $row['name'],
            'value' => $percentage,
            'hrs' => $row['hours'] . " hrs",
            'color' => $row['color']
        ];
    }
    $response['subject_distribution'] = $subject_data;

    // JSON ထုတ်ပေးခြင်း
    echo json_encode($response);

} else {
    echo json_encode(["status" => "error", "message" => "Invalid User ID"]);
}
?>