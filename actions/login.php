<?php
session_start();
require '../config/db.php';
require '../helpers/sanitize.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Correo inválido']);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            $current_datetime = date('Y-m-d H:i:s');

            $update_stmt = $mysqli->prepare("UPDATE users SET last_login = ? WHERE id = ?");
            $update_stmt->bind_param("si", $current_datetime, $id);
            $update_stmt->execute();
            $update_stmt->close();

            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }

    $stmt->close();
    $mysqli->close();
}
