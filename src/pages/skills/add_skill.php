<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Skills related functions
require_once('../../utils/skills.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
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
    <title>Add Skill</title>
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
                    <span>Add New Skill</span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <?php if (isset($_SESSION['messageError'])) {
                    echo $_SESSION['messageError'];
                    unset($_SESSION['messageError']);
                } ?>

                <form class="form-dashboard" action="../../server/skills.php" method="post" autocomplete="off">
                    <div class="input-group">
                        <label for="nameField">Name</label>
                        <input type="text" name="skill" id="nameField" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="typeField">Type</label>
                        <select name="type" id="typeField">
                            <?php renderSkillsType($conn); ?>
                        </select>
                    </div>
                    <button type="submit" name="addSkillSubmit">
                        <i class="fa-regular fa-plus"></i>
                        Add New Skill
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>
