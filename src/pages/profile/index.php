<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
                    <span>My Profile</span>
                </div>

                <form action="../../server/profile.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <?php if(isset($_SESSION['messageError'])) {
                        echo $_SESSION['messageError'];
                        unset($_SESSION['messageError']);
                    } else if (isset($_SESSION['messageSuccess'])) {
                        echo $_SESSION['messageSuccess'];
                        unset($_SESSION['messageSuccess']);
                    }
                    ?>
                    <div class="input-group">
                        <label for="imageField">Profile Image</label>
                        <input type="file" name="image" id="imageField" accept="image/jpeg, image/png, image/jpg">
                    </div>
                    <div class="input-group">
                        <label for="usernameField">Username</label>
                        <input type="text" name="username" id="usernameField" value="<?= $user['username'] ?>" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="emailField">E-mail</label>
                        <input type="email" name="email" id="emailField" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="passwordField">Password</label>
                        <input type="password" name="pass" id="passwordField">
                    </div>
                    <div class="input-group">
                        <label for="confirmPasswordField">Confirm Password</label>
                        <input type="password" name="confirmPass" id="confirmPasswordField">
                    </div>
                    <button class="button-icon" name="updateProfileSubmit" type="submit">
                        <i class="fa-regular fa-arrows-rotate"></i>
                        <span>Update</span>
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>