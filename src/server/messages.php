<?php

// Require the database connection
require_once('../config/config.php');

// Start the session
session_start();

// If the form in the portfolio is submitted
if(isset($_POST['addMessageSubmit'])) {
    // Verify if the email that was inputted exists more than the count limit
    $sql = "SELECT COUNT(email) FROM tblMessage WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", "$_POST['']");
        // If it exists, return to the form with an error
        $_SESSION['messageError'] = "You've maxed out the number of messages you can send.";

    // Verify if the same message was already sent from the same user
}

?>