<?php
session_start();
require '../config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
$stmt->execute([':name' => $username]);
$user = $stmt->fetch();

if ($user && $password === $user['password_hash']) {
    $_SESSION['admin_id'] = $user['id'];
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid login.";
}
