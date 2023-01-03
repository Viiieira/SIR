<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Messages functions
require_once('../../utils/messages.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ./");
    exit();
}

// Get all the information about the message with that id
$sql = "SELECT * FROM tblMessage WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$message = $stmt->fetch(PDO::FETCH_ASSOC);

unset($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <?php require_once('../../components/head_links.php'); ?>
</head>
<body>

<div id="dashboard-wrapper">
    <div id="dashboard-container">
        <?php require_once('../../components/sidebar.php'); ?>
        <main>
            <?php require_once('../../components/navbar.php'); ?>
            <article id="users">

                <div class="article-title">
                    <span>Message #<?php echo $message['id']; ?></span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <table class="table shadow">
                    <tr>
                        <th>Name</th>
                        <td><?php echo $message['name']; ?></td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td><?php echo $message['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td><?php echo date("j F Y, g:i a", strtotime($message['dtInserted'])); ?></td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td><?php echo $message['message']; ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td><?php printMessageState($conn, $_GET['id']); ?></td>
                    </tr>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>