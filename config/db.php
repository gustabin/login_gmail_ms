<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Validar que las variables de entorno necesarias estén definidas
$required_env_vars = [
    'CLIENT_ID',
    'CLIENT_SECRET',
    'CLIENT_ID_MS',
    'CLIENT_SECRET_MS',
    'SMTP_USERNAME',
    'SMTP_PASSWORD',
    'SMTP_HOST',
    'SMTP_PORT',
    'DB_HOST',
    'DB_USER',
    'DB_PASS',
    'DB_NAME',
    'REDIRECT_URI_LOCAL',
    'REDIRECT_URI_MS_LOCAL',
    'REDIRECT_URI_REMOTE',
    'REDIRECT_URI_MS_REMOTE',
    'DB_HOST_REMOTE',
    'DB_USER_REMOTE',
    'DB_PASS_REMOTE',
    'DB_NAME_REMOTE'
];

foreach ($required_env_vars as $var) {
    if (!isset($_ENV[$var])) {
        die("Error: La variable de entorno {$var} no está definida.");
    }
}

// Configuración de Google
define('CLIENT_ID', $_ENV['CLIENT_ID']);
define('CLIENT_SECRET', $_ENV['CLIENT_SECRET']);

// Configuración de Microsoft
define('CLIENT_ID_MS', $_ENV['CLIENT_ID_MS']);
define('CLIENT_SECRET_MS', $_ENV['CLIENT_SECRET_MS']);

// Configuración del servidor SMTP
define('SMTP_USERNAME', $_ENV['SMTP_USERNAME']);
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
define('SMTP_HOST', $_ENV['SMTP_HOST']);
define('SMTP_PORT', $_ENV['SMTP_PORT']);

// Configuración del entorno (Local o Remoto)
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Localhost
    define('REDIRECT_URI', $_ENV['REDIRECT_URI_LOCAL']);
    define('REDIRECT_URI_MS', $_ENV['REDIRECT_URI_MS_LOCAL']);
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASS', $_ENV['DB_PASS']);
    define('DB_NAME', $_ENV['DB_NAME']);
} elseif ($_SERVER['SERVER_NAME'] === 'stackcodelab.com' || $_SERVER['SERVER_NAME'] === 'www.stackcodelab.com') {
    // Servidor remoto
    define('REDIRECT_URI', $_ENV['REDIRECT_URI_REMOTE']);
    define('REDIRECT_URI_MS', $_ENV['REDIRECT_URI_MS_REMOTE']);
    define('DB_HOST', $_ENV['DB_HOST_REMOTE']);
    define('DB_USER', $_ENV['DB_USER_REMOTE']);
    define('DB_PASS', $_ENV['DB_PASS_REMOTE']);
    define('DB_NAME', $_ENV['DB_NAME_REMOTE']);
} else {
    die('Error: Entorno no reconocido.');
}

// Conexión a la base de datos
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_error) {
        throw new Exception('Error de conexión: ' . $mysqli->connect_error);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    die('No se pudo conectar a la base de datos.');
}
