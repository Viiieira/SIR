<?php

// Start the session
session_start();

// Require the database connection
require_once "../config/config.php";

// if the form is submitted
if(isset($_POST['updateIntroSubmit'])) {
    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
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
                    $sql = "UPDATE tblHeader
                    SET title=:title, description=:description, ";
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
        // Update only text fields

    }
}
?>