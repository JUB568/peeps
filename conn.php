<?php
loadEnv(__DIR__ . '/.env');

// Aiven DB credentials
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');
$database = getenv('DB_NAME');


$mysqli = mysqli_init();
$mysqli->ssl_set(null, null, getCaPemPath(), null, null);

if (!$mysqli->real_connect($host, $user, $password, $database, $port, null, MYSQLI_CLIENT_SSL)) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

$mysqli->set_charset("utf8mb4");



function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception(".env file not found at path: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Remove optional surrounding quotes
        $value = trim($value, '"\'');
        putenv("$key=$value");
    }
}

// Function to get relative path to SSL cert
function getCaPemPath(): string {
    $path = __DIR__ . '/ca.pem'; // Adjust 'certs' folder if needed
    if (!file_exists($path)) {
        die("❌ SSL certificate not found at: $path");
    }
    return $path;
}

// You can now use $mysqli for queries
?>
