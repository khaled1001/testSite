<?php
header('Content-Type: application/json');
require 'config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST requests allowed.']);
    exit;
}

// Parse incoming JSON
$data = json_decode(file_get_contents('php://input'), true);

// Basic validation
if (!isset($data['title'], $data['details'], $data['benefit'], $data['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields.']);
    exit;
}

// Trim and assign variables
$title = trim($data['title']);
$details = trim($data['details']);
$benefit = trim($data['benefit']);
$name = trim($data['name']);

try {
    // Prepare and execute insert query
    $stmt = $pdo->prepare("
        INSERT INTO requests (title, details, benefit, submitted_name)
        VALUES (:title, :details, :benefit, :submitted_name)
    ");
    $stmt->execute([
        ':title' => $title,
        ':details' => $details,
        ':benefit' => $benefit,
        ':submitted_name' => $name
    ]);

    // Success response
    echo json_encode(['success' => true, 'message' =>]()_
