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
    header('Location: ../portfolio/');
    exit();
}

if(empty($_GET['id'])) {
    header('Location: ./');
    exit();
}

$sql = "SELECT * FROM tblContact WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

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
                    <span>Edit Contact #<?php echo $row['id']; ?></span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <form action="../../server/contacts.php" method="post" autocomplete="off">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <?php
                    if(isset($_SESSION['messageError'])) {
                        echo $_SESSION['messageError'];
                        unset($_SESSION['messageError']);
                    }
                    ?>
                    <div class="input-group">
                        <label for="typeField">Type</label>
                        <select name="type" id="typeField" required>
                            <?php printContactTypeById($conn, $row['type']); ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="contactField">Contact</label>
                        <input type="text" name="contact" id="contactField" value="<?php echo $row['contact']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="displayContactField">Display Contact</label>
                        <input type="text" name="displayContact" id="dislayContactField" value="<?php echo $row['displayContact']; ?>" required>
                    </div>
                    <button type="submit" name="editContactSubmit" class="button-icon">
                        <i class="fa-regular fa-add"></i>
                        <span>Update Contact</span>
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>