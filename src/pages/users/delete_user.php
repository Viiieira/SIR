<?php

// Start the session
session_start();

// Include the database connection file
require_once '../../config/config.php';

if(isset($_GET['id'])) {
    // Get the data from the get method
    $id = $_GET['id'];

    // Delete the section access from the user
    $sql = "DELETE FROM tblManagerSectionAccess WHERE idManager = :id";
    // Prepare the statement, bind the parameteres and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Delete the user from the database
    $sql = "DELETE FROM tblUser WHERE id = :id";
    // Prepare the statement, bind the parameteres and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the statement was executed
    if($stmt->rowCount() > 0) {
        // Set the session message
        $_SESSION['deleteUserSuccess'] = "User deleted successfully";
    } else {
        // Set the session message
        $_SESSION['deleteUserError'] = "User not deleted";
    }
    // Redirect to the users page
} else {
    // Redirect to the users page
    $_SESSION['deleteUserError'] = "Something went wrong";
}
header("Location: ./");
exit();

?>