<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
require_once('../../utils/contacts.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Contact</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article>
                <div class="article-title">
                    <span>Add New Contact</span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <form class="form-dashboard" action="../../server/contacts.php" method="post" autocomplete="off">
                    <?php if(isset($_SESSION['messageError'])) {
                        echo $_SESSION['messageError'];
                        unset($_SESSION['messageError']);
                    } ?>
                    <div class="input-group">
                        <label for="iconField">Icon</label>
                        <select name="icon" id="iconField" required>
                            <?php printContactType($conn); ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="displayContactField">Display Name</label>
                        <input type="text" name="displayContact" id="displayContactField" required>
                    </div>
                    <div class="input-group">
                        <label for="contactField">Contact</label>
                        <input type="text" name="contact" id="contactField" required>
                    </div>
                    <button type="submit" name="addContactSubmit">
                        <i class="fa-regular fa-plus"></i>
                        Add New Contact
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>
