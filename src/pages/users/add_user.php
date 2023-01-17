<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// User related functions
require_once('../../utils/users.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    header('Location: ./');
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
    <title>Add User</title>
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
                    <span>Add New User</span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <form class="form-dashboard" action="../../server/users.php" method="post" autocomplete="off">
                    <?php if(isset($_SESSION['addUserError'])) {
                        echo $_SESSION['addUserError'];
                        unset($_SESSION['addUserError']);
                    } ?>
                    <div class="input-group">
                        <label for="usernameField">Username</label>
                        <input type="text" name="username" id="usernameField" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="emailField">E-mail</label>
                        <input type="email" name="email" id="emailField" required>
                    </div>
                    <div class="input-group">
                        <label for="passwordField">Password</label>
                        <input type="password" name="password" id="passwordField" required>
                    </div>
                    <div class="input-group">
                        <label for="confirmPasswordField">Confirm Password</label>
                        <input type="password" name="confirmPassword" id="confirmPasswordField" required>
                    </div>
                    <div class="input-group">
                        <label for="selectAddUser">Role</label>
                        <select name="role" id="selectAddUser" required>
                            <option disabled selected>-- Role --</option>
                            <?php printUserRoleAdd($conn); ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="stateField">State</label>
                        <select name="state" id="stateField" required>
<!--                            <option disabled selected>-- State --</option>-->
                            <?php printUserStateAdd($conn); ?>
                        </select>
                    </div>
                    <div id="addManagerForm" class="hidden">
                        <div class="article-subtitle">Sections</div>
                        <?php renderManagerSections($conn); ?>
                    </div>
                    <button type="submit" name="addUserSubmit" class="button-icon">
                        <i class="fa-regular fa-plus"></i>
                        Add User
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>
