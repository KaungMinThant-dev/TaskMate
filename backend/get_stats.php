<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'db_connect.php';

// ၁။ Total Users
$users_query = $conn->query("SELECT COUNT(*) FROM users");
$total_users = $users_query->fetchColumn();

// ၂။ Total Tasks
$tasks_query = $conn->query("SELECT COUNT(*) FROM tasks");
$total_tasks = $tasks_query->fetchColumn();

// ၃။ Completed Tasks
$completed_query = $conn->query("SELECT COUNT(*) FROM tasks WHERE status = 'Completed'");
$completed_tasks = $completed_query->fetchColumn();

// ၄။ Active Users (နောက်ဆုံး ၂၄ နာရီအတွင်း)
$threshold = date('Y-m-d H:i:s', strtotime('-24 hours'));
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE last_login >= ? AND status = 'active'");
$stmt->execute([$threshold]);
$active_users = $stmt->fetchColumn();

// ၅။ အားလုံးကို တစ်ခါတည်း ပေါင်းပြီး JSON နဲ့ Response ပြန်ပါ
echo json_encode([
    "total_users" => (int)$total_users,
    "total_tasks" => (int)$total_tasks,
    "completed_tasks" => (int)$completed_tasks,
    "active_users" => (int)$active_users 
]);
?>