<!-- Sidebar -->
<div id="sidebar">
    <a href="../statistics/" class="sidebar-brand-sm">P</a>
    <a href="../statistics/" class="sidebar-brand">Portfolio</a>

    <nav class="sidebar-tabs">
        <h5 class="sidebar-title">Menu</h5>
        <?php
        // Manager and Admin Section
        $sqlManagerSection = "
            SELECT s.section, s.icon
            FROM tblUser AS u, tblSection AS s, tblManagerSectionAccess AS msa
            WHERE u.id = msa.idManager AND s.id = msa.idSection AND u.id = :id";
        $sqlAdminSection = "SELECT * FROM tblSection";

        if($_SESSION['role'] == 1) {
            $stmt = $conn->prepare($sqlAdminSection);
        } else if ($_SESSION['role'] == 2) {
            $stmt = $conn->prepare($sqlManagerSection);
            $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        }
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            while ($section = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

        <a href="../<?php echo strtolower($section['section']); ?>/" class="sidebar-link">
            <div class="sidebar-link-icon">
                <i class="fa-regular <?php echo $section['icon']; ?>"></i>
            </div>
            <span><?php echo $section['section'] ?></span>
        </a>

        <?php } } ?>
        <a href="../calculator/" class="sidebar-link">
            <div class="sidebar-link-icon">
                <i class="fa-regular fa-calculator"></i>
            </div>
            <span>Calculator</span>
        </a>
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
        <a href="../portfolio/" class="sidebar-link">
            <div class="sidebar-link-icon">
                <i class="fa-regular fa-arrow-left"></i>
            </div>
            <span>Go Back</span>
        </a>
    </div>
</div>