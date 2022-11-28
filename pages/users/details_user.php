<?php

// Start the session
session_start();
// Require the mysqli connection
require_once('../../config/config.php');
// Function for logout
require_once('../../server/logout.php');
// Utilitary functions
require_once('../../utils/utils.php');
// User related functions
require_once('../../server/users.php');

// No login detected
if(!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ../login/');
    exit();
}

// If the user is a manager,
// verify if he has access to the section
if($_SESSION['role'] == 2) {
    // If he has no access
    if(verifyManagerSectionAccess("Users", $conn) == false) {
        // Redirect to dashboard
        header('Location: ../dashboard/');
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
                <div class="go-back" onclick="window.location.href='./'">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Go Back</span>
                </div>
                <div class="article-title">
                    <?php echo ($userx['role'] == 1) ? "Admin" : "Manager"; echo " | "; echo $userx['username']; ?>
                </div>

                <table class="table shadow">
                    <tr>
                        <td>id: </td>
                        <th><?php echo $userx['id']; ?></td>
                    </tr>
                    <tr>
                        <td>username: </td>
                        <th><?php echo $userx['username']; ?></td>
                    </tr>
                    <tr>
                        <td>email: </td>
                        <th><?php echo $userx['email']; ?></td>
                    </tr>
                    <tr>
                        <td>dtCreated: </td>
                        <th><?php echo date("j F Y, g:i a", strtotime($userx['dtCreated'])) ?></td>
                    </tr>
                    <tr>
                        <td>role: </td>
                        <th><?php echo ($userx['role'] == 1) ? "Admin" : "Manager"; ?></td>
                    </tr>
                </table>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>