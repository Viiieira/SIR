<?php

define('DB_SERVER', 'host.docker.internal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sir_backend_db');

try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    // Define Error Mode for PDO Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Failed to connect to the database. " . $e->getMessage());
}

?>