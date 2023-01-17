<?php

function printStatsUsersRole ($conn, $role) {
    $sql = "SELECT * FROM tblUser WHERE role=:role";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":role", $role, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount();
}

function printStatsMessages ($conn, $type) {
    // 1 - New Messages
    // 2 - Replied
    // 3 - Blocked Spammers
    if($type === 1 || $type === 2) {
        $sql = "SELECT * FROM tblMessage WHERE state=:state";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":state", $type, PDO::PARAM_INT);
        $stmt->execute();
    } elseif ($type === 3) {
        $sql = "SELECT * FROM tblBlock";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    return $stmt->rowCount();
}

function printStatsContacts ($conn) {
    $sql = "SELECT * FROM tblContact";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

function printStatsLanguages ($conn) {
    $sql = "SELECT * FROM tblLanguage";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

function printStatsSkills ($conn, $type) {
    $sql = "SELECT * FROM tblSkill WHERE type=:type";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type", $type, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount();
}

function printStatsEducation($conn) {
    $sql = "SELECT * FROM tblEducation";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

?>