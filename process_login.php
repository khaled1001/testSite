<?php
session_start();
require '../config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name AND is_admin = 1");
$stmt->execute([':name' => $username]);
$user = $stmt->fetch();

if ($user && hash('sha256', $password) === $user['password_hash']) {
    $_SESSION['admin_id'] = $user['id'];
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid login.";
}
