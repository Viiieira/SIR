<?php

session_start();
require_once('../config/config.php');

if(isset($_POST['editUserSubmit'])) {
    $sql = "UPDATE tblUser SET role=:role WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':role', $_POST['role'], PDO::PARAM_INT);
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['editSuccessUser'] = "User edited successfully!";
        header('Location: ../pages/users/');
        exit();
    }
}

if(isset($_POST['addUserSubmit'])) {
    $pass = $_POST['password'];
    $pass = md5($_POST['password']);

    $sql = "INSERT INTO tblUser (username, email, pass) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
    $stmt->bindParam(":password", $pass, PDO::PARAM_STR);
    if($stmt->execute()) {
        $_SESSION['addUserSuccess'] = "User added successfully!";
        header("Location: ../pages/users/");
    } else {
        $_SESSION['addUserError'] = "Something went wrong!";
        header("Location: ../pages/users/add_user.php");
    }
    exit();
}

?>