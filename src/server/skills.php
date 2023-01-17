<?php

ob_start();

// Start the session
session_start();

// Require the database connection
require_once("../config/config.php");

if(isset($_POST['updateSkillSubmit'])) {
    print_r($_POST);

    // Check if there's already a skill with that name
    $sql = "SELECT * FROM tblSkill WHERE skill=:skill AND id<>:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":skill", $_POST['skill']);
    $stmt->bindParam("id", $_POST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($stmt->rowCount() > 0) {
        $_SESSION['messageError'] = "{$row['skill']} is already added.";
        header('Location: ../pages/skills/');
        exit();
    }

    // Update the skill
    $sql = "UPDATE tblSkill SET skill=:skill, type=:type WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":skill", $_POST['skill']);
    $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_INT);
    $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "{$_POST['skill']} has been updated.";
    } else {
        $_SESSION['messageError'] = "{$_POST['skill']} didn't get any changes.";
    }
    header('Location: ../pages/skills/');
    exit();
}

if(isset($_GET['delete'])) {
    print_r($_GET);

    // Get the data about the skill that is getting deleted
    $sql = "SELECT * FROM tblSkill WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the skill is getting deleted is found, delete it
    // otherwise, redirect the user back to the index
    if($stmt->rowCount() == 1) {
        $sql = "DELETE FROM tblSkill WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "{$row['skill']} was successfully deleted.";
        } else {
            $_SESSION['messageError'] = "{$row['skill']} couldn't be deleted.";
        }
    } else {
        $_SESSION['messageError'] = "Something went wrong";
    }
    header('Location: ../pages/skills/');
    exit();
}

if(isset($_POST['addSkillSubmit'])) {
    print_r($_POST);

    // Search if there's already a skill with that name
    $sql = "SELECT * FROM tblSkill WHERE skill=:skill";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":skill", $_POST['skill']);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['messageError'] = "{$row['skill']} is already added to the system";
        header('Location: ../pages/skills/add_skill.php');
    } else {
        // Insert the new skill
        $sql = "INSERT INTO tblSkill (skill, type) VALUES (:skill, :type)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":skill", $_POST['skill']);
        $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "{$_POST['skill']} was added successfully";
            header('Location: ../pages/skills/');
        } else {
            $_SESSION['messageError'] = "{$_POST['skill']} couldn't be added to the system";
            header('Location: ../pages/skills/add_skill.php');
        }
        exit();
    }
}

ob_end_flush();

?>