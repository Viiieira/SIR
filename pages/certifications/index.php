<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../includes/config.php');
// Function for logout
require_once('../includes/logout.php');
// Utilitary functions
require_once('../utils/utils.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Certifications", $conn) == false) {
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
    <title>Certifications</title>
    <?php require_once('../includes/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../includes/sidebar.php'); ?>
        <main>
            <?php require_once('../includes/navbar.php'); ?>
            <article id="dashboard">
                <div class="article-title">Certifications</div>
            </article>
        </main>
    </div>
</div>

<?php require_once('../includes/body_links.php'); ?>

</body>
</html>