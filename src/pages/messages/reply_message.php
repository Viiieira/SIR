<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// Messages related functions
require_once('../../utils/messages.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../portfolio/');
    exit();
}

if(empty($_GET['id']) || verifyIssetMessage($conn, $_GET['id']) == 0) {
    header('Location: ./');
}

$message = returnMessageData($conn, $_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply Message #<?= $message['id'] ?></title>
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
                    <!-- Title + Filter -->
                    <div>
                        <span>Reply Message #<?= $message['id'] ?></span>
                    </div>
                    <div>
                        <button class="button-icon" onclick="window.location.href='./'">
                            <i class="fa-regular fa-arrow-left"></i>
                            <span>Go Back</span>
                        </button>
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

                <form action="../../server/messages.php" method="post" autocomplete="off">
                    <input type="hidden" name="id" value="<?= $message['id'] ?>">
                    <input type="hidden" name="to" value="<?= $message['email'] ?>">
                    <div class="input-group">
                        <label for="headerField">Header</label>
                        <input type="text" name="header" id="headerField" required autofocus>
                    </div>
                    <div class="input-group">
                        <label for="messageField">Message</label>
                        <textarea name="message" id="messageField" cols="30" rows="10" required></textarea>
                    </div>
                    <button type="submit" class="button-icon" name="replyMessageSubmit">
                        <i class="fa-regular fa-paper-plane"></i>
                        <span>Reply</span>
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>