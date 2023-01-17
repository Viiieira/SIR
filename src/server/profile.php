<?php

ob_start();

// Start the session
session_start();

// Require the database connection
require_once "../config/config.php";

if(isset($_POST['updateProfileSubmit'])) {
    print_r($_POST);
    print_r($_FILES);



    // Verify if the user uploaded an image
    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
        // Verify if there's already a user with that name or that email
        $sql = "SELECT * FROM tblUser WHERE (username=:username OR email=:email) AND id<>:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $_POST['username']);
        $stmt->bindParam(":email", $_POST['email']);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        // The query found a user with the same username as the one that the user is trying to update into
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(strcmp($row['username'], $_POST['username']) == 0) {
                $_SESSION['messageError'] = "{$row['username']} already exists.";
            } else if (strcmp($row['email'], $_POST['email']) == 0) {
                $_SESSION['messageError'] = "{$row['email']} already exists.";
            }
            header('Location: ../pages/profile/');
            exit();
        }

        // MOVING FILE CODE
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir ='../assets/images/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Verify if the user also wanted to update his password
                if(empty($_POST['pass']) && empty($_POST['confirmPass'])) {
                    $sql = "UPDATE tblUser
                    SET username=:username, email=:email, imgPath=:imgPath
                    WHERE id=:id";
                    $stmt = $conn->prepare($sql);
                } else {
                    // Verify if both the password and confirmed password are equal
                    if(strcmp($_POST['pass'], $_POST['confirmPass']) !== 0) {
                        $_SESSION['messageError'] = "Password do not match.";
                        header('Location: ../pages/profile/');
                        exit();
                    }
                    $newPass = md5($_POST['pass']);
                    $sql = "UPDATE tblUser
                            SET username=:username, email=:email, pass=:pass, imgPath=:imgPath
                            WHERE id=:id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":pass", $newPass);
                }
                $stmt->bindParam(":imgPath", $newFileName, PDO::PARAM_STR);
            } else {
                $_SESSION['messageError'] = "Something went wrong uploading your image";
                header('Location: ../pages/profile/');
                exit();
            }
        }
    } else {
        // Verify if there's already a user with that name or that email
        $sql = "SELECT * FROM tblUser WHERE (username=:username OR email=:email) AND id<>:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $_POST['username']);
        $stmt->bindParam(":email", $_POST['email']);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        // The query found a user with the same username as the one that the user is trying to update into
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(strcmp($row['username'], $_POST['username']) == 0) {
                $_SESSION['messageError'] = "{$row['username']} already exists.";
            } else if (strcmp($row['email'], $_POST['email']) == 0) {
                $_SESSION['messageError'] = "{$row['email']} already exists.";
            }
            header('Location: ../pages/profile/');
            exit();
        }

        // Verify if the user also wanted to update his password
        if(empty($_POST['pass']) && empty($_POST['confirmPass'])) {
            $sql = "UPDATE tblUser SET username=:username, email=:email WHERE id=:id";
            $stmt = $conn->prepare($sql);
        } else {
            // Verify if both the password and confirmed password are equal
            if(strcmp($_POST['pass'], $_POST['confirmPass']) !== 0) {
                $_SESSION['messageError'] = "Password do not match.";
                header('Location: ../pages/profile/');
                exit();
            }
            $newPass = md5($_POST['pass']);
            $sql = "UPDATE tblUser SET username=:username, email=:email, pass=:pass WHERE id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":pass", $newPass);
        }
    }

    $stmt->bindParam(":username", $_POST['username']);
    $stmt->bindParam(":email", $_POST['email']);
    $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "Your account was updated";
        $_SESSION['username'] = $_POST['username'];
    } else {
        $_SESSION['messageError'] = "Something went wrong updating your account";
    }
    header('Location: ../pages/profile/');
    exit();
}

ob_end_flush();

?>