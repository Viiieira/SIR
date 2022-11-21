<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'DBSIR';

$conn = new mysqli($server, $user, $pass, $db);
$conn->set_charset("utf8mb4");

if(!$conn) {
    die('Something went wrong with the database');
}

?>