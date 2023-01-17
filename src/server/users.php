<?php

session_start();
require_once('../config/config.php');
require_once('../utils/utils.php');

if(isset($_POST['editUserSubmit'])) {
    $sql = "UPDATE tblUser SET role=:role WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':role', $_POST['role'], PDO::PARAM_INT);
    $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "User edited successfully!";
        header('Location: ../pages/users/');
    }
    exit();
}

/* Insert User
 * -- By default, all managers can have access to the "Messages" section
 * -- Only Admins can add new Admins or Managers, and
 *        only them can select the new user's role or state when inserted
*/
if(isset($_POST['addUserSubmit'])) {
//    print_r($_POST); exit();

    // Verify if both passwords match
    if(strcmp($_POST['confirmPassword'], $_POST['password']) !== 0) {
        $_SESSION['addUserError'] = "Passwords do not match.";
        header('Location: ../pages/users/add_user.php');
        exit();
    }

    // Variables
    $pass = md5($_POST['password']);

    // Verify if there's already a user with that username
    $sql = "SELECT * FROM tblUser WHERE username=:username OR email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If there's already a user with that username
        $_SESSION['messageError'] = "There's already an user with that ";
        if(strcmp($user['username'], $_POST['username']) == 0) {
            $_SESSION['messageError'] .= "username ({$user['username']}) ";
        } else if (strcmp($user['email'], $_POST['email']) == 0) {
            $_SESSION['messageError'] .= "email {$user['email']}";
        }
        header("Location: ../pages/users/add_skill.php");
    } else {
        // Insert the user
        $sql = "INSERT INTO tblUser (username, email, pass, role, state) VALUES (:username, :email, :password, :role, :state)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $pass, PDO::PARAM_STR);
        $stmt->bindParam("role", $_POST['role'], PDO::PARAM_INT);
        $stmt->bindParam("state", $_POST['state'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "User added successfully!";

            // If the user added is a manager, add the "Messages" section access
            if($_POST['role'] == 2) {
                $lastUser = getLastUserId($conn);
                foreach($_POST['section'] as $section) {
                    $sql = "INSERT INTO tblManagerSectionAccess VALUES (:idManager, :idSection)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":idManager", $lastUser, PDO::PARAM_INT);
                    $stmt->bindParam(":idSection", $section, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            header("Location: ../pages/users/");
        } else {
            $_SESSION['messageError'] = "Something went wrong!";
            header("Location: ../pages/users/add_skill.php");
        }
    }
}