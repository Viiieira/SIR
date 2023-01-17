<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Education related functions
require_once('../../utils/education.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Education", $conn) == false) {
        // Redirect to statistics
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
    <title>Education</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="education">
                <div class="article-title">
                    <!-- Title + Filter -->
                    <div>
                        <span>Education</span>
                    </div>
                    <div>
                        <form action="" class="filter__search" method="GET" autocomplete="off">
                            <button type="submit" class="filter__search-submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <input type="text" name="search" placeholder="Search..." required>
                        </form>
                        <div class="filter">
                            <div id="filterToggler" class="button-icon">
                                <i class="fa-regular fa-filter"></i>
                            </div>
                        </div>
                        <button class="button-icon" onclick="window.location.href='add_education.php'">
                            <i class="fa-regular fa-plus"></i>
                            <span>Add School</span>
                        </button>
                    </div>
                </div>
                <!-- Filter Options -->
                <form action="" method="get" class="filter__menu hidden" id="filterMenu">
                    <?php renderEducationFilters(); ?>
                    <div class="filter__options">
                        <button type="submit"class="button-icon">
                            <i class="fa-regular fa-paper-plane"></i>
                            <span>OK</span>
                        </button>
                        <a href="./">
                            <i class="fa-regular fa-trash"></i>
                        </a>
                    </div>
                </form>

                <?php if (isset($_SESSION['messageSuccess'])) {
                    echo "<p>{$_SESSION['messageSuccess']}</p>";
                    unset($_SESSION['messageSuccess']);
                } else if (isset($_SESSION['messageError'])) {
                    echo "<p>{$_SESSION['messageError']}</p>";
                    unset($_SESSION['messageError']);
                }

                ?>

                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>School Name</th>
                            <th>School Acronym</th>
                            <th>Date</th>
                            <th>Level</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody><?php printEducation($conn, $_GET); ?></tbody>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>