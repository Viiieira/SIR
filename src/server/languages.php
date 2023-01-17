<?php

ob_start();

// Start the session
session_start();

// Database connection
require_once "../config/config.php";

if(isset($_POST['editLanguageSubmit'])) {
    // Query if the there's already a language with that name
    $sql = "SELECT * FROM tblLanguage WHERE name=:name AND id<>:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $_POST['name']);
    $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $_SESSION['messageError'] = "{$_POST['name']} is already added.";
        header('Location: ../pages/languages/');
        exit();
    } else {
        // Update the language
        $sql = "UPDATE tblLanguage SET name=:name, level=:level WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $_POST['name'], PDO::PARAM_STR);
        $stmt->bindParam(":level", $_POST['level'], PDO::PARAM_INT);
        $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['messageSuccess'] = "<p>The language was updated to <b>{$_POST['name']}</b></p>";
        header('Location: ../pages/languages/');
        exit();
    }
}

if(isset($_POST['addLanguageSubmit'])) {
    // Verify if that language was already added
    $sql = "SELECT * FROM tblLanguage WHERE name=:name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $_POST['language'], PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        $_SESSION['messageError'] = "This language is already added.";
        header('Location: ../pages/languages/add_language.php');
        exit();
    } else {
        $sql = "INSERT INTO tblLanguage (name, level) VALUES (:name, :level)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name" ,$_POST['language']);
        $stmt->bindParam(":level", $_POST['level'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "{$_POST['language']} was successfully added.";
            header('Location: ../pages/languages/');
            exit();
        } else {
            $_SESSION['messageError'] = "Something went wrong adding the new language";
            header('Location: ../pages/languages/add_language.php');
            exit();
        }
    }
}

if(isset($_GET['delete'])) {
    // Get the name of the language for when being removed
    $sql = "SELECT name FROM tblLanguage WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $language = $stmt->fetch(PDO::FETCH_ASSOC)['name'];

    // Delete the user with the passed id
    $sql = "DELETE FROM tblLanguage WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "$language was successfully removed.";
    } else {
        $_SESSION['messageError'] = "Something went wrong removing the new language";
    }
    header('Location: ../pages/languages/');
    exit();
}

ob_end_flush();

?>