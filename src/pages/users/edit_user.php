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
                
                <form action="../../server/users.php" method="post" class="form-section" autocomplete="off">
                    <!-- <div class="form-section__input-group">
                        <label for="usernameFiled">Username</label>
                        <input type="text" name="username" id="usernameField" value="<?php echo $userx['username']; ?>" required autofocus>
                    </div>
                    <div class="form-section__input-group">
                        <label for="emailField">E-mail</label>
                        <input type="email" name="email" id="emailField" value="<?php echo $userx['email']; ?>" required>
                    </div>
                    <div class="form-section__input-group">
                        <label for="passwordField">Password</label>
                        <input type="password" name="password" id="passwordField" required>
                    </div>
                    <div class="form-section__input-group">
                        <label for="imageField">Profile Picture</label>
                        <input type="file" name="image" id="imageField">
                    </div> -->
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="form-section__input-group">
                        <label for="roleField">Role</label>
                        <select name="role" id="roleField">
                            <?php printUserRolesSelect ($conn, $userx['role']); ?>
                        </select>
                    </div>

                    <button type="submit" name="editUserSubmit">
                        Edit User
                    </button>
                </form>
            </article>
        </main>
    </div>
</div>

<?php require_once('../../components/body_links.php'); ?>

</body>
</html>