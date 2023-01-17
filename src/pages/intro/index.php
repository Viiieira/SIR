<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Introduction related functions
require_once('../../utils/intro.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

$intro = returnIntroData($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="calculator">
                <div class="article-title">
                    <span>Introduction</span>
                </div>

                <form action="../../server/intro.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="input-group">
                        <label for="nameField">Name</label>
                        <input type="text" name="name" id="nameField" value="<?= $intro['title'] ?>" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="descriptionField" value="<?= $intro['description'] ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="backgroundImage">Background Image</label>
                        <input type="file" name="image" id="backgroundImageField" accept="image/jpeg, image/png">
                    </div>
                    <button type="submit" class="button-icon" name="updateIntroSubmit">
                        <i class="fa-regular fa-arrows-rotate"></i>
                        <span>Update Introduction</span>
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>