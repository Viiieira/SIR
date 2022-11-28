<?php

// Print all users
function printUsers ($conn, $role) {
    // Query
    if ($role == 0) {
        $sqlUsers = "SELECT id, username, email, dtCreated, role FROM tblUser";
    } else {
        $sqlUsers = "SELECT id, username, email, dtCreated, role FROM tblUser WHERE role=" . $role;
    }
    $stmt = $conn->prepare($sqlUsers);
    $stmt->execute();
    
    // Print values into a table
    if($stmt->rowCount() > 0) {
        while($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td data-label='E-mail'>" . $user['email'] . "</td>";
            echo "<td data-label='Username'>" . $user['username'] . "</td>";
            echo "<td>" . date("j F Y, g:i a", strtotime($user['dtCreated'])) . "</td>";
            echo "<td data-label='Options'><a href='details_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-eye'></i></a>";
            echo "<a href='_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-pencil'></i></a>";
            echo "<a href='details_user.php?id=" . $user['id'] . "'><i class='fa-regular fa-trash'></i></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan=4>There are no records</td></tr>";
    }

    unset($stmt);
    unset($stmtUsersRole);
}

?>