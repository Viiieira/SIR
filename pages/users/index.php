<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');

// CRUD User related functions
require_once('../../server/users.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Users", $conn) == false) {
        // Redirect to dashboard
        header('Location: ../dashboard/');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="users">
                <div class="article-title">Admins</div>

                <table class="table shadow">
                    <thead>
                        <tr>
                            <th>E-mail</th>
                            <th>Username</th>
                            <th>Creation Date</th>
                            <th colspan="3">Options</th>
                        </tr>
                    </thead>
                    <tbody><?php printUsers($conn, 1); ?></tbody>
                </table>

                <div class="article-title">Managers</div>

                <table class="table shadow">
                    <thead>
                        <tr>
                            <th>E-mail</th>
                            <th>Username</th>
                            <th>Creation Date</th>
                            <th colspan="3">Options</th>
                        </tr>
                    </thead>
                    <tbody><?php printUsers($conn, 2); ?></tbody>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>