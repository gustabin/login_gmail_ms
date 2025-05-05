<?php
require '../config/db.php';
require '../helpers/sanitize.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

$client_id = CLIENT_ID_MS;
$client_secret = CLIENT_SECRET_MS;
$redirect_uri = REDIRECT_URI_MS;

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $token_request = [
        'client_id' => $client_id,
        'scope' => 'user.read',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code',
        'client_secret' => $client_secret,
    ];

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded",
            'content' => http_build_query($token_request)
        ]
    ]);

    $token_response = file_get_contents('https://login.microsoftonline.com/common/oauth2/v2.0/token', false, $context);
    $token_data = json_decode($token_response, true);
    $access_token = $token_data['access_token'];

    $opts = [
        'http' => [
            'header' => "Authorization: Bearer $access_token"
        ]
    ];
    $context = stream_context_create($opts);
    $user_info = file_get_contents("https://graph.microsoft.com/v1.0/me", false, $context);
    $user = json_decode($user_info, true);
    $email = sanitize_email($user['userPrincipalName']);

    $current_datetime = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $user_id = $user_data['id'];

        $update_stmt = $mysqli->prepare("UPDATE users SET last_login = ? WHERE id = ?");
        $update_stmt->bind_param("si", $current_datetime, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (email, password, created_at, last_login) VALUES (?, '', ?, ?)");
        $stmt->bind_param("sss", $email, $current_datetime, $current_datetime);
        $stmt->execute();
        $user_id = $mysqli->insert_id;
    }

    $stmt->close();

    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;

    header("Location: ../public/dashboard.html");
    exit;
}
