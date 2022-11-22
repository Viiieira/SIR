<!-- Sidebar -->
<div id="sidebar">
    <a href="../dashboard/" class="sidebar-brand-sm">P</a>
    <a href="../dashboard/" class="sidebar-brand">Portfolio</a>

    <nav class="sidebar-tabs">
        <h5 class="sidebar-title">Menu</h5>
        <?php
        // Manager and Admin Section
        $sqlManagerSection = "SELECT s.section, s.icon FROM tblUser AS u, tblSection AS s, tblManagerSectionAccess AS msa WHERE u.id = msa.idManager AND s.id = msa.idSection AND u.id = " . $_SESSION['id'];
        $sqlAdminSection = "SELECT * FROM tblSection";

        if($_SESSION['role'] == 1) {
            $resultSection = $conn->query($sqlAdminSection);
        } else if ($_SESSION['role'] == 2) {
            $resultSection = $conn->query($sqlManagerSection);
        }

        if($resultSection->num_rows > 0) {
            while($section = $resultSection->fetch_assoc()) { ?>

        <a href="../<?php echo strtolower($section['section']); ?>/" class="sidebar-link">
            <div class="sidebar-link-icon">
                <i class="fa-regular <?php echo $section['icon']; ?>"></i>
            </div>
            <span><?php echo $section['section'] ?></span>
        </a>

        <?php } } ?>
    </nav>
    
    <hr>

    <div class="sidebar-tabs">
        <h5 class="sidebar-title">Options</h5>
        <a href="#" class="sidebar-link" id="toggleLight">
            <div class="sidebar-link-icon">
                <i class="fa-regular" id="toggleLightIcon"></i>
            </div>
            <span id="toggleLightLabel">Light Theme</span>
        </a>
        <a href="?logout" class="sidebar-link">
            <div class="sidebar-link-icon">
                <i class="fa-regular fa-arrow-right-from-bracket"></i>
            </div>
            <span>Logout</span>
        </a>
    </div>
</div>