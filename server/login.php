<?php

session_start();
require_once('../config/config.php');

if(isset($_POST['loginSubmit'])) {
    // Variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Search for the user in the database
    $sql = "SELECT * FROM tblUser WHERE email = :email AND pass = :password LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', md5($password), PDO::PARAM_STR);
    $stmt->execute();

    // If the user is found, log him in
    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../pages/dashboard/');
    } else {
        // Send the user back to the dashboard,
        // with the error stored in the session
        $_SESSION['loginError'] = "Dados incorretos!";
        header('Location: ../pages/login/');
    }

    unset($stmt);
    exit();
}


?>