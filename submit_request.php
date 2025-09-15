<?php
header('Content-Type: application/json');

// Include your existing DB config
require 'config.php';

// Read raw POST data (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Basic validation
if (!isset($data['title'], $data['details'], $data['benefit'], $data['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Sanitize inputs
$title = trim($data['title']);
$details = trim($data['details']);
$benefit = trim($data['benefit']);
$name = trim($data['name']);

try {
    $stmt = $pdo->prepare("
        INSERT INTO requests (title, details, benefit, submitted_name)
        VALUES (:title, :details, :benefit, :submitted_name)
    ");
    $stmt->execute([
        ':title' => $title,
        ':details' => $details,
        ':benefit' => $benefit,
        ':submitted_name' => $name,
    ]);

    echo json_encode(['success' => true, 'message' => 'Request submitted successfully.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
