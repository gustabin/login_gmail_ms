<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user_email'])) {
    echo json_encode(['success' => true, 'email' => $_SESSION['user_email']]);
} else {
    echo json_encode(['success' => false, 'error' => 'Sesión no activa']);
}
