<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Welcome, Admin</h2>
    <a href="admin_logout.php">Logout</a>

    <h3>All Requests</h3>

    <?php foreach ($requests as $r): ?>
        <div class="request-card">
            <h4><?= htmlspecialchars($r['title']) ?> (<?= $r['status'] ?>)</h4>
            <p><?= htmlspecialchars($r['details']) ?></p>
            <p><strong>Submitted by:</strong> <?= htmlspecialchars($r['submitted_name']) ?></p>

            <form method="POST" action="update_request.php">
                <input type="hidden" name="id" value="<?= $r['id'] ?>">
                <select name="status">
                    <option value="Open" <?= $r['status'] === 'Open' ? 'selected' : '' ?>>Open</option>
                    <option value="Under Review" <?= $r['status'] === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                    <option value="Completed" <?= $r['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
