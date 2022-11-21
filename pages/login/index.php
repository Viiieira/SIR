<?php

session_start();

if(isset($_SESSION['id']) && $_SESSION['username']) {
    header('Location: ../dashboard/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php  require_once('../includes/head_links.php'); ?>
</head>
<body>

<div id="form-wrapper">
    <div class="form-container">
        <div class="form-brand">Portfolio</div>
        <form action="../includes/login.php" method="post" autocomplete="off">
            <div class="form-input">
                <label for="emailField">
                    E-mail <span class="text-secondary">*</span>
                </label>
                <input type="email" name="email" id="emailField" placeholder="johndoe@company.com" required autofocus>
                <?php
                    
                if(isset($_SESSION['loginError'])) {
                    echo "<div class='text-danger'>" . $_SESSION['loginError'] . "</div>";
                    unset($_SESSION['loginError']);
                }
                
                ?>
            </div>
            <div class="form-input">
                <label for="passwordField">Password <span class="text-secondary">*</span></label>
                <input type="password" name="password" id="passwordField" placeholder="********" required>
            </div>
            <button type="submit" name="loginSubmit">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
        </form>
    </div>
</div>

<?php require_once('../includes/body_links.php'); ?>

</body>
</html>