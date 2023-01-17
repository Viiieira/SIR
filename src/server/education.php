<?php

ob_start();

// Start the session
session_start();

// Require the database connection
require_once("../config/config.php");

// If the delete action is clicked
if(isset($_GET['delete'])) {
    // If somehow the id is not passed
    if(empty($_GET['id'])) { header('Location: ../pages/education/'); }
    // Search if the school has paragraphs
    $sql = "SELECT * FROM tblEducationParagraph WHERE idEducation=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();

    // Found paragraphs of that school to be deleted
    if($stmt->rowCount() > 0) {
        $sql = "DELETE FROM tblEducationParagraph WHERE idEducation=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    // Get the name of the school in order to print the school that has been deleted
    $sql = "SELECT schoolAcronym FROM tblEducation WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $schoolAcronym = $stmt->fetch(PDO::FETCH_ASSOC)['schoolAcronym'];

    // Delete the school itself
    $sql = "DELETE FROM tblEducation WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "<b>{$schoolAcronym}</b> was sucessfully deleted";
    } else {
        $_SESSION['messageError'] = "Something went wrong trying to delete <b>{$schoolAcronym}</b>.";
    }
    header('Location: ../pages/education/');
    exit();
}

if(isset($_POST['addEducationSubmit'])) {
    print_r($_POST);

    // Verify if, the dtEnd exists, if its less than the dtStart
    if(!empty($_POST['dtEnd'])) {
        if($_POST['dtEnd'] > $_POST['dtStart']) {
            $_SESSION['messageError'] = "The Ended Date can't be greater than then Started Date";
            header('Location: ../pages/education/add_education.php');
            exit();
        }
    }

    // Verify if there's already a school with that acronym
    $sql = "SELECT * FROM tblEducation WHERE schoolAcronym=:name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $_POST['schoolAcronym'], PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['messageError'] = "<b>{$row['schoolAcronym']}</b> already exists";
        header('Location: ../pages/education/add_education.php');
        exit();
    }

    // Verify if there's already a school with that name
    $sql = "SELECT * FROM tblEducation WHERE schoolFullName=:name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $_POST['schoolFullName'], PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['messageError'] = "<b>{$row['schoolFullName']}</b> already exists";
        header('Location: ../pages/education/add_education.php');
        exit();
    }

    // Insert the School
    $sql = "INSERT INTO tblEducation (schoolFullName, schoolAcronym, dtStart, dtEnd, level)
            VALUES
                (:schoolFullName, :schoolAcronym, :dtStart, :dtEnd, :level)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":schoolFullName", $_POST['schoolFullName'], PDO::PARAM_STR);
    $stmt->bindParam(":schoolAcronym", $_POST['schoolAcronym'], PDO::PARAM_STR);
    $stmt->bindParam(":dtStart", $_POST['dtStart'], PDO::PARAM_INT);
    if(!isset($_POST['dtEnd'])) {
        $dtEnd = 9999;
        $stmt->bindParam(":dtEnd", $dtEnd, PDO::PARAM_INT);
    } else {
        $stmt->bindParam(":dtEnd", $_POST['dtEnd'], PDO::PARAM_INT);
    }
    $stmt->bindParam(":level", $_POST['level'], PDO::PARAM_STR);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "<b>{$_POST['schoolAcronym']}</b> has been added";
    } else {
        $_SESSION['messageError'] = "Something went wrong adding <b>{$_POST['schoolAcronym']}</b>";
    }
    header('Location: ../pages/education/');
    exit();
}

ob_end_flush();

?>