<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
require_once('../../utils/messages.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="messages">
                <div class="article-title">
                    <!-- Title + Filter -->
                    <div>
                        <span>Messages</span>
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
                    </div>
                </div>
                <!-- Filter Options -->
                <form action="" method="get" class="filter__menu hidden" id="filterMenu">
                    <?php renderMessageFilters(); ?>
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

                <table class="table table-responsive shadow">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Message</th>
                            <th>State</th>
                            <th>Replied</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php printMessages($conn, $_GET); ?>
                    </tbody>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>