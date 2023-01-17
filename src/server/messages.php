<?php

// Require the database connection
require_once('../config/config.php');

// Start the session
session_start();

if(isset($_POST['replyMessageSubmit'])) {
    print_r($_POST);

    // Send email with the response
    if(mail($_POST['to'], $_POST['header'], $_POST['message'])) {
        $state = 2; // Replied state
        // Update the message row, to update his state and insert the id of the user that replied
        $sql = "UPDATE tblMessage SET state=:state, idUserReply=:idUser WHERE id=:idMessage";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":state", $state, PDO::PARAM_INT);
        $stmt->bindParam(":idUser", $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindParam(":idMessage", $_POST['id'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "Your reply was succesfully sent";
        } else {
            $_SESSION['messageError'] = "The message was not updated";
        }
        header('Location: ../pages/messages/');
        exit();
    } else {
        $_SESSION['messageError'] = "Your email was not sent";
        header('Location: ../pages/messages/');
        exit();
    }
}

?>