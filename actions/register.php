<?php
session_start();
require '../config/db.php';
require '../helpers/sanitize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'error' => 'The password must be at least 6 characters long.']);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'The email is already registered']);
        exit;
    }
    $stmt->close();

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error registering user']);
    }

    $stmt->close();
    $mysqli->close();
}
