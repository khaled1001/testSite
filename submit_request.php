<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $benefit = trim($_POST['benefit'] ?? '');
    $submitted_name = trim($_POST['name'] ?? '');

    if (empty($title) || empty($details) || empty($submitted_name)) {
        echo "Please fill in all required fields.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO requests (title, details, benefit, submitted_name)
            VALUES (:title, :details, :benefit, :submitted_name)
        ");
        $stmt->execute([
            ':title' => $title,
            ':details' => $details,
            ':benefit' => $benefit,
            ':submitted_name' => $submitted_name
        ]);

        echo "Your idea has been submitted successfully!";
    } catch (PDOException $e) {
        echo "Error submitting request.";
    }
}
?>
