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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New School</title>
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
                        <span>New School</span>
                    </div>
                    <div>
                        <button class="button-icon" onclick="window.location.href='./'">
                            <i class="fa-regular fa-arrow-left"></i>
                            <span>Go Back</span>
                        </button>
                    </div>
                </div>

                <?php if (isset($_SESSION['messageSuccess'])) {
                    echo "<p>{$_SESSION['messageSuccess']}</p>";
                    unset($_SESSION['messageSuccess']);
                } else if (isset($_SESSION['messageError'])) {
                    echo "<p>{$_SESSION['messageError']}</p>";
                    unset($_SESSION['messageError']);
                }

                ?>

                <form action="../../server/education.php" method="post" autocomplete="off">
                    <div class="input-group">
                        <label for="schoolAcronymField">School Acronym</label>
                        <input type="text" name="schoolAcronym" id="schoolAcronymField" placeholder="IPVC-ESTG" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="schoolFullNameField">School Full Name</label>
                        <input type="text" name="schoolFullName" id="schoolFullNameField" placeholder="Instituto Politécnico de Viana do Castelo - Escola Superior de Tecnologia e Gestão" required>
                    </div>
                    <div class="input-group">
                        <label for="dtStartField">Started Year</label>
                        <input type="number" min="1900" max="<?= date("Y"); ?>" placeholder="<?= date("Y"); ?>" name="dtStart" id="dtStartField" required>
                    </div>
                    <!-- Checkbox for toggling the ending date usability -->
                    <div class="input-group">
                        <input type="checkbox" id="dtEndToggler" onclick="toggleEndDateField()">
                        <label>This stage isn't finished yet</label>
                    </div>
                    <div class="input-group">
                        <label for="dtEndField">Ended Year</label>
                        <input type="number" name="dtEnd" id="dtEndField" min="1900" max="<?= date("Y"); ?>" placeholder="<?= date("Y"); ?>">
                    </div>
                    <div class="input-group">
                        <label for="levelField">Level</label>
                        <input type="text" name="level" id="levelField" placeholder="University" required>
                    </div>
                    <button type="submit" name="addEducationSubmit" class="button-icon">
                        <i class="fa-regular fa-plus"></i>
                        <span>Add School</span>
                    </button>
                </form>


            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>