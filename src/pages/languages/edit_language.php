<?php
ob_start();

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Languages related functions
require_once('../../utils/languages.php');


// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
}

if(empty($_GET['id'])) {
    header('Location: ./');
    exit();
}

ob_end_flush();

$sql = "SELECT * FROM tblLanguage WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Language</title>
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
                    <span>Edit Language</span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <form class="form-dashboard" action="../../server/languages.php" method="post" autocomplete="off">
                    <?php if(isset($_SESSION['messageError'])) {
                        echo $_SESSION['messageError'];
                        unset($_SESSION['messageError']);
                    } ?>
                    <div class="input-group">
                        <label for="languageField">Language</label>
                        <select name="language" id="languageField">
                            <?php renderNewLanguageName($conn); ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="levelField">Level</label>
                        <select name="level" id="levelField" required>
                            <?php renderNewLanguageLevels($conn); ?>
                        </select>
                    </div>
                    <button type="submit" name="addLanguageSubmit">
                        <i class="fa-regular fa-plus"></i>
                        Add New Language
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>
