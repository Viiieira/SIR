<?php

/*
define('DB_SERVER', 'localhost');
define('DB_USER', 'id20128288_root');
define('DB_PASS', 'BPhXncz2AjG#');
define('DB_NAME', 'id20128288_sir');

define('DB_SERVER', 'host.docker.internal');
define('DB_USER', 'SIR');
define('DB_PASS', 'SIR');
define('DB_NAME', 'SIR');

*/

define('DB_SERVER', 'host.docker.internal');
define('DB_USER', 'SIR');
define('DB_PASS', 'SIR');
define('DB_NAME', 'SIR');

try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    // Define Error Mode for PDO Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Failed to connect to the database. " . $e->getMessage());
}

?>