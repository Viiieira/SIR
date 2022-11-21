<?php

$sqlUserRole = "SELECT name FROM tblRole WHERE id=" . $_SESSION['role'];
$resultUserRole = $conn->query($sqlUserRole);
$role = $resultUserRole->fetch_assoc();

// Get the information from the user logged in
$sql = "SELECT * FROM tblUser WHERE id=".$_SESSION['id'];
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>
<div id="navbar">
    <div class="navbar-section navbar-title"><?php echo $role['name']; ?></div>
    <div class="navbar-section navbar-user">
        <div class="navbar-dropdown" id="navbar-dropdown">
            <img src="<?php echo $user['imgPath']; ?>" class="navbar-img" alt=""> 
            <div class="navbar-dropdown-title"><?php echo $_SESSION['username']; ?></div>
            <i class="fa-regular fa-chevron-down"></i>
        </div>
    </div>
</div>

<ul class="navbar-dropdown-menu hidden" id="navbar-dropdown-menu">
    <li class="navbar-drowpdown-item">
        <a href="#" class="navbar-dropdown-link">
            <i class="fa-regular fa-address-card"></i>
            <span>My Profile</span>
        </a>
    </li>
    <li class="navbar-dropdown-item">
        <a href="#" class="navbar-dropdown-link">
            <i class="fa-regular fa-clock-rotate-left"></i>
            <span>My History</span>
        </a>
    </li>
    <li class="navbar-dropdown-item">
        <a href="?logout" class="navbar-dropdown-link">
            <i class="fa-regular fa-arrow-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>