<?php

require '../config/db.php';
require '../helpers/sanitize.php';
require '../mail/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_email($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email']);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt->close();

        $stmt = $mysqli->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

        $link = "https://stackcodelab.com/login_gmail_ms/public/reset_password.html?token=$token";
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = 'true';
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = SMTP_PORT;

            $mail->setFrom('soporte@stackcodelab.com', 'Stackcodelab Support');
            $mail->addAddress($email);

            $mail->Subject = 'Password recovery';
            $mail->Body    = "Click the link below to reset your password.:\n\n$link";

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'A recovery link has been sent to your email.']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error sending email: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['error' => 'Email not found']);
    }
}
