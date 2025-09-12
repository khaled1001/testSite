<?php
require 'config.php';

$request_id = $_POST['request_id'] ?? 0;
$user_id = $_POST['user_id'] ?? 0;

if ($request_id && $user_id) {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        $stmt = $pdo->prepare("UPDATE requests SET claimed_by = ?, status = 'Under Review' WHERE id = ?");
        $stmt->execute([$user_id, $request_id]);
        echo "Request claimed.";
    } else {
        echo "Unauthorized user";
    }
}
?>
