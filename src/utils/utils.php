<?php

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

// Print all users
function printUsers ($conn, $role) {
    // Query to select all users in the database
    if ($role == 0) {
        $sqlUsers = "SELECT * FROM tblUser";
    } else {
        $sqlUsers = "SELECT * FROM tblUser WHERE role = " . $role;
    }
    $sqlUsers .= " AND id <> ".$_SESSION['id'];
    $stmt = $conn->prepare($sqlUsers);
    $stmt->execute();
    
    // Print values into a table
    if($stmt->rowCount() > 0) {
        while($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td data-label='E-mail'>" . $user['email'] . "</td>";
            echo "<td data-label='Username'>" . $user['username'] . "</td>";
            echo "<td>" . date("j F Y, g:i a", strtotime($user['dtCreated'])) . "</td>";
            echo "<td data-label='Options'>";
            echo "<a href='details_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-eye'></i></a>";
            echo "<a href='edit_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-pencil'></i></a>";
            echo "<a href='delete_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-trash'></i></a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan=4>There are no records</td></tr>";
    }

    unset($stmt, $stmtUsersRole);
}

function printUserRolesSelect ($conn, $userRole) {
    $sql = "SELECT * FROM tblRole";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row['id'] == $userRole) {
            echo "<option value=" .$row['id']. " selected='selected'>".$row['name']."</option>";
        } else {
            echo "<option value=" .$row['id']. ">".$row['name']."</option>";
        }
    }
}

?>