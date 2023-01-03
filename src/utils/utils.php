<?php

// Function to verify if the user should have access to the specified section
function verifyManagerSectionAccess($section, $conn) {
    $verifySectionManager = "
        SELECT msa.idManager, msa.idSection
        FROM tblManagerSectionAccess AS msa, tblUser AS u, tblSection AS s
        WHERE msa.idManager = u.id AND msa.idSection = s.id
            AND u.id = :id AND s.section = :section";
    $stmt = $conn->prepare($verifySectionManager);
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindParam(':section', $section, PDO::PARAM_STR);
    $stmt->execute();

    if($stmt->rowCount() == 0) {
        return false;
    }
    return true;
}

// Function to get the last user inserted
function getLastUserId($conn) {
    $sql = "SELECT * FROM tblUser ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user['id'];
}

?>