<?php

ob_start();

// Start the session
session_start();

// Require the database connection
require_once "../config/config.php";

if(isset($_POST['sendMessageSubmit'])) {
    // Get the IP of the user
    // If the user is behind a proxy or a load balancer, use a different method to get the IP
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Validate if the IP is legit
    if(filter_var($ip, FILTER_VALIDATE_IP)) {
        // Query if the user is not in the blacklist
        $sql = "SELECT * FROM tblBlock WHERE ip=:ip";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":ip", $ip, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() === 0) {
            // Query if the same ip already sent over 10 messages in the current day
            $sql = "SELECT COUNT(*) as count
                    FROM tblMessage m
                    WHERE m.ip=:ip AND DATE(dtInserted) = CURDATE()
                    HAVING count <= 10";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":ip", $ip, PDO::PARAM_STR);
            $stmt->execute();

            // If the message is not being submitted by a blocked ip
            if($stmt->rowCount() == 1) {
                // Insert the message
                $sql = "INSERT INTO tblMessage (name, email, message, ip) VALUES (:name, :email, :message, :ip)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
                $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
                $stmt->bindParam(":message", $_POST['message'], PDO::PARAM_STR);
                $stmt->bindParam(":ip", $ip, PDO::PARAM_STR);
                if($stmt->execute()) {
                    $_SESSION['messageSuccess'] = "Your message has been sent!";
                } else {
                    $_SESSION['messageError'] = "Something went wrong sending your message";
                }
            } else {
                // Insert the IP into the blocklist
                $sql = "INSERT INTO tblBlock (ip) VALUES (:ip)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":ip", $ip, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }
    header('Location: ../pages/portfolio/');
    exit();
}

ob_end_flush();

?>