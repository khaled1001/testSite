<?php
require 'config.php';

$request_id = $_POST['request_id'] ?? 0;
$ip_address = $_SERVER['REMOTE_ADDR'];

if ($request_id && filter_var($request_id, FILTER_VALIDATE_INT)) {
    try {
        $stmt = $pdo->prepare("INSERT INTO votes (ip_address, request_id) VALUES (?, ?)");
        $stmt->execute([$ip_address, $request_id]);

        echo json_encode(['status' => 'success', 'message' => 'Upvoted']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Already voted']);
    }
}
?>
