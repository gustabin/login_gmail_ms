<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../config/db.php';
require '../helpers/sanitize.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

$current_datetime = date('Y-m-d H:i:s');

$client_id = CLIENT_ID;
$client_secret = CLIENT_SECRET;
$redirect_uri = REDIRECT_URI;

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    error_log('Code received from Google: ' . $code);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://oauth2.googleapis.com/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ]
    ]);

    $token_response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    error_log('Token response (HTTP ' . $http_code . '): ' . $token_response);

    $token_data = json_decode($token_response, true);

    if (!isset($token_data['access_token'])) {
        error_log('Error obtaining access token. Full response: ' . print_r($token_data, true));
        echo "Error obtaining access token. See logs for details.";
        exit;
    }

    $access_token = $token_data['access_token'];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://www.googleapis.com/oauth2/v2/userinfo',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access_token
        ]
    ]);

    $user_info = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    error_log('Response from userinfo (HTTP ' . $http_code . '): ' . $user_info);

    $user = json_decode($user_info, true);

    if (!isset($user['email'])) {
        error_log('The user´s email address could not be retrieved. Response: ' . print_r($user, true));
        echo "Error retrieving user information. See logs for details.";
        exit;
    }

    $email = sanitize_email($user['email']);
    error_log('User email: ' . $email);

    $current_datetime = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $user_id = $user_data['id'];
        error_log('Existing user found with ID: ' . $user_id . ', updating last_login');

        $update_stmt = $mysqli->prepare("UPDATE users SET last_login = ? WHERE id = ?");
        $update_stmt->bind_param("si", $current_datetime, $user_id);

        if (!$update_stmt->execute()) {
            error_log('Error updating last_login: ' . $update_stmt->error);
        } else {
            error_log('last_login successfully updated for user ID: ' . $user_id);
        }
        $update_stmt->close();
    } else {
        error_log('Creating a new user with email: ' . $email);

        $stmt = $mysqli->prepare("INSERT INTO users (email, password, created_at, last_login) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $empty_password, $current_datetime, $current_datetime);

        $empty_password = '';

        if (!$stmt->execute()) {
            error_log('Error inserting user: ' . $stmt->error);
            echo "Error inserting user into the database: " . $stmt->error;
            exit;
        }

        $user_id = $mysqli->insert_id;
        error_log('New user created with ID: ' . $user_id);
    }

    if (!$user_id) {
        error_log('Could not obtain a valid user ID');
        echo "Error: Could not obtain a valid user ID";
        exit;
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;

    error_log('User saved in session, redirecting to dashboard');
    header("Location: ../public/dashboard.html");
    exit;
}
