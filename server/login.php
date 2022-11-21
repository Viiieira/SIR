<?php

session_start();
require_once('../config/config.php');

if(isset($_POST['loginSubmit'])) {
    // Variables
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $password = md5($password);

    $sql = "SELECT * FROM tblUser WHERE email='$email' AND pass='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../pages/dashboard/');
    } else {
        $_SESSION['loginError'] = "Dados incorretos!";
        header('Location: ../../pages/login/');
    }
    exit();
}


?>