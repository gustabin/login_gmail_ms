<?php
require '../config/db.php';
$client_id = CLIENT_ID_MS;
$redirect_uri = REDIRECT_URI_MS;
$scope = urlencode('user.read');

$url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize?" .
    "client_id=$client_id&response_type=code&redirect_uri=$redirect_uri&scope=$scope";

header("Location: $url");
exit;
