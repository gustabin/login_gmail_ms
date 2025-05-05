<?php
require '../config/db.php';
$client_id = CLIENT_ID;
$redirect_uri = REDIRECT_URI;

$scope = urlencode('email profile');

$url = "https://accounts.google.com/o/oauth2/v2/auth?" .
    "client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=$scope";

header("Location: $url");
exit;
