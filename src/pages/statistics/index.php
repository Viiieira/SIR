<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Statistics related functions
require_once('../../utils/statistics.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Statistics", $conn) == false) {
        // Log him out the session
        header('Location: ../messages/');
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
    <title>Dashboard</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="dashboard">
                <div class="article-title">Statistics</div>

                <div class="stats-container">
                    <div class="stats-card">
                        <div class="stats-card__title">
                            Admins
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsUsersRole($conn, 1); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Managers
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsUsersRole($conn, 2); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            New
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsMessages($conn, 1); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Replied
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-envelope-circle-check"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsMessages($conn, 2); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Blocked
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-circle-exclamation"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsMessages($conn, 3); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Contacts
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-address-book"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsContacts($conn); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Languages
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-language"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsLanguages($conn); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Soft Skills
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-pen-ruler"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsSkills($conn, 1); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Hard Skills
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-pen-ruler"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsSkills($conn, 2); ?></div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-card__title">
                            Education
                        </div>
                        <div class="stats-card__icon">
                            <i class="fa-regular fa-school"></i>
                        </div>
                        <div class="stats-card__number"><?= printStatsEducation($conn); ?></div>
                    </div>
                </div>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>