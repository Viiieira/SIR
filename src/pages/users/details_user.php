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

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Users", $conn) == false) {
        // Redirect to statistics
        header('Location: ../messages/');
        exit();
    }
}

$sql = "SELECT * FROM tblUser WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$userx = $stmt->fetch(PDO::FETCH_ASSOC);

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
                    <span>User #<?php echo $userx['id']; ?></span>
                    <div class="button-icon" onclick="window.location.href='./'">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Go Back</span>
                    </div>
                </div>

                <table class="table shadow">
                    <tr>
                        <th>Username</th>
                        <td><?php echo $userx['username']; ?></td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td><?php echo $userx['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Creation Date</th>
                        <td><?php echo date("j F Y, g:i a", strtotime($userx['dtCreated'])) ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><?php echo ($userx['role'] == 1) ? "Admin" : "Manager"; ?></td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            <?php if($userx['state'] == 1) { ?>
                                <div class="user-state deactive"></div> Deactive
                            <?php } else { ?>
                                <div class="user-state active"></div> Active
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>