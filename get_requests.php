<?php
require 'config.php';

$stmt = $pdo->query("
    SELECT r.*, u.name AS claimed_by_name,
           (SELECT COUNT(*) FROM votes WHERE request_id = r.id) AS vote_count
    FROM requests r
    LEFT JOIN users u ON r.claimed_by = u.id
    ORDER BY vote_count DESC, r.created_at DESC
");

echo json_encode($stmt->fetchAll());
?>
