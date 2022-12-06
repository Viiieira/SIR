<?php

$sqlUserRole = "SELECT name FROM tblRole WHERE id = :role";
$stmt = $conn->prepare($sqlUserRole);
$stmt->bindParam(':role', $_SESSION['role'], PDO::PARAM_INT);
$stmt->execute();
$role = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the information from the user logged in
$sql = "SELECT * FROM tblUser WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<div id="navbar">
    <div class="navbar-section navbar-user">
        <div class="navbar-dropdown" id="navbar-dropdown">
            <img src="../../assets/images/<?php echo $user['imgPath']; ?>" class="navbar-img" alt=""> 
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