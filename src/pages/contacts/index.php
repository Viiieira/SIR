<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Contacts functions
require_once('../../utils/contacts.php');

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
    <title>Contacts</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="contacts">
                <div class="article-title">
                    <!-- Title + Filter -->
                    <div>
                        <span>Contacts</span>
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
                    <?php renderContactFilters(); ?>
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
                <?php printContacts($conn, $_GET); ?>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>