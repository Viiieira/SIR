<?php

session_start();
require_once('../config/config.php');

if(isset($_POST['loginSubmit'])) {
    // Variables
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Search for the active user in the database
    $sql = "SELECT * FROM tblUser WHERE email = :email AND pass = :password and state=2 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

    // If the user is found, log him in
    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // If the user is an admin, redirect him to the statistics
        // if the user is a manager, redirect him to the first section that he has access to
        if($_SESSION['role'] == 1) {
            header('Location: ../pages/statistics/');
        } else {
            $sql = "
                SELECT s.section
                FROM tblManagerSectionAccess msa, tblSection s
                WHERE msa.idManager =:idManager AND msa.idSection = s.id LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("idManager", $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() == 0) {
                header('Location: ../pages/messages/');
            } else {
                $firstSection = $stmt->fetch(PDO::FETCH_NUM);
                header("Location: ../pages/" . strtolower($firstSection[0]));
            }
        }
    } else {
        // Send the user back to the statistics,
        // with the error stored in the session
        $_SESSION["loginError"] = "Incorrect data!";
        $_SESSION["tempEmail"] = $_POST['email'];
        header('Location: ../pages/login/');
    }
    exit();
}


?>