<?php

// Start the session
session_start();
// Require the pdo connection
require_once('../../config/config.php');
// Utilitary functions
require_once('../../utils/utils.php');

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if($_SESSION['role'] == 2) {
        header('Location: ./');
        exit();
    }

    // Delete all the user section access
    $sql = "UPDATE tblUser SET role=:role, state=:state WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":role", $_POST['role'], PDO::PARAM_INT);
    $stmt->bindParam(":state", $_POST['state'], PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "User updated with success!";
    } else {
        $_SESSION['messageError'] = "Something went wrong with updating the user!";
    }
    header("Location: ./");
    exit();
}

?>