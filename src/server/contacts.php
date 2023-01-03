<?php

// Fix for "Warning: Cannot modify header information"
ob_start();

// Start the session
session_start();

// Require the database connection
require_once "../config/config.php";

// If the Add Contact form is submitted
if(isset($_POST['addContactSubmit'])) {
    print_r($_POST);

    // Verify if the contact was already added to the system before
    $sql = "SELECT * FROM tblContact WHERE contact = :contact OR displayContact = :displayContact";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":contact", $_POST['contact'], PDO::PARAM_STR);
    $stmt->bindParam(":displayContact", $_POST['displayContact'], PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        $_SESSION['messageError'] = "This contact is already in the system.";
        header('Location: ../pages/contacts/add_contact.php');
        exit();
    }
    unset($stmt);

    // Add the new Contact
    $sql = "INSERT INTO tblContact (type, contact, displayContact) VALUES (:type, :contact, :displayContact)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type", $_POST['icon'], PDO::PARAM_INT);
    $stmt->bindParam(":contact", $_POST['contact']);
    $stmt->bindParam(":displayContact", $_POST['displayContact']);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "The new contact was added successfully.";
        header('Location: ../pages/contacts/');
        exit();
    } else {
        $_SESSION['messageError'] = "Something went wrong adding the new contact";
        header('Location: ../pages/contacts/add_contact.php');
        exit();
    }
}

if(isset($_POST['editContactSubmit'])) {
    // Verify if the user did any modification at all
    $sql = "SELECT * FROM tblContact WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['type'] == $_POST['type'] && strcmp($row['contact'], $_POST['contact']) == 0 && strcmp($row['displayContact'], $_POST['displayContact']) == 0) {
        header('Location: ../pages/contacts/edit_contact.php?id=' . $_POST['id']);
        exit();
    } else {
        // Verify if there's already a contact with that contact
        $sql = "SELECT * FROM tblContact WHERE id<>:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // The strings are different
            if(strcmp($row['contact'], $_POST['contact']) === 0) {
                $_SESSION['messageError'] = "That contact already exists";
                header('Location: ../pages/contacts/edit_contact.php?id=' . $_POST['id']);
                exit();
            }
        }

        // Update the contact
        $sql = "
            UPDATE tblContact
            SET type=:type,
                contact=:contact,
                displayContact=:displayContact
            WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":type", $_POST['type'], PDO::PARAM_INT);
        $stmt->bindParam(":contact", $_POST['contact'], PDO::PARAM_STR);
        $stmt->bindParam(":displayContact", $_POST['displayContact'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
        if($stmt->execute()) {
            $_SESSION['messageSuccess'] = "The contact \"{$_POST['displayContact']}\" was updated";
            header('Location: ../pages/contacts/');
            exit();
        } else {
            $_SESSION['messageError'] = "Something went wrong updating that contact";
            header('Location: ../pages/contacts/edit_contact.php?id=' . $_POST['id']);
            exit();
        }
    }
}

if(isset($_GET['delete'])) {
    $sql = "DELETE FROM tblContact WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $_SESSION['messageSuccess'] = "The contact was deleted.";
    } else {
        $_SESSION['messageError'] = "An error ocurred trying to delete the contact.";
    }
    header('Location: ../pages/contacts/');
    exit();
}

ob_end_flush();

?>