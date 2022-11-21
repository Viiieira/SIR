<?php

function verifyManagerSectionAccess($section, $conn) {
    $verifySectionManager = "
        SELECT msa.idManager, msa.idSection
        FROM tblManagerSectionAccess AS msa, tblUser AS u, tblSection AS s
        WHERE msa.idManager = u.id AND msa.idSection = s.id
            AND u.id=" . $_SESSION['id'] . " AND s.section='". $section . "'";
    $resultVerifySectionManager = $conn->query($verifySectionManager);

    if($resultVerifySectionManager->num_rows == 0) {
        return false;
    }
    return true;
}

?>