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

?>