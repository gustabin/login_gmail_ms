<?php
require '../config/db.php';
require '../helpers/sanitize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';

    if (strlen($password) < 6) {
        echo json_encode(['error' => 'The password must be at least 6 characters long.']);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt->close();

        $update = $mysqli->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $update->bind_param("si", $hashed, $user_id);
        $update->execute();

        echo json_encode(['success' => true, 'message' => 'Your password has been updated.']);
    } else {
        echo json_encode(['error' => 'Invalid or expired token']);
    }
}
