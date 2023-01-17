<?php

// Function to render the information contained inside the Hero Section
function returnHeroData($conn) {
    $sql = "SELECT * FROM tblHeader";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function renderResumeData($conn) {
    $sql = "SELECT * FROM tblResume";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>{$row['paragraph']}</p>";
    }
}

function renderSkillsData($conn, $type) {
    $sql = "SELECT skill FROM tblSkill WHERE type=:type";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":type", $type, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>{$row['skill']}</li>";
    }
}

function returnImage($conn) {
    $sql = "SELECT * FROM tblImage";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function renderEducationData($conn) {
    // Order by chronological order
    $sql = "SELECT * FROM tblEducation ORDER BY dtEnd DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"education-card\">";
            echo "<div class=\"education-date\">";
                echo "<table>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<td>From</td>";
                            echo "<td>To</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td>{$row['dtStart']}</td>";
                            echo ($row['dtEnd'] !== 9999) ? "<td>{$row['dtEnd']}</td>" : "<td>Present</td>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                        echo "<tr>";
                            echo "<td>{$row['schoolAcronym']}</td>";
                            echo "<td>{$row['level']}</td>";
                        echo "</tr>";
                    echo "</tbody>";
                echo "</table>";
            echo "</div>";
            echo "<div class=\"education-info\">";
                echo "<h3>{$row['schoolFullName']}</h3>";
                $sqlP = "SELECT * FROM tblEducationParagraph WHERE idEducation=:id";
                $stmtP = $conn->prepare($sqlP);
                $stmtP->bindParam(":id", $row['id'], PDO::PARAM_INT);
                $stmtP->execute();
                if($stmtP->rowCount() > 0) {
                    while ($rowP = $stmtP->fetch(PDO::FETCH_ASSOC)) {
                        echo "<p>{$rowP['paragraph']}</p>";
                    }
                }
            echo "</div>";
        echo "</div>";
    }
}

function returnEducationRows($conn) {
    $sql = "SELECT * FROM tblEducationParagraph";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function returnContactRows ($conn) {
    $sql = "SELECT * FROM tblContact";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}

function renderContacts($conn) {
    $sql = "SELECT c.type, c.contact, c.displayContact, ct.name, ct.icon, ct.typeLink
            FROM tblContact c, tblContactType ct
            WHERE c.type = ct.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch($row['typeLink']) {
            case 1:
                echo "<a href=\"{$row['contact']}\" target=\"_blank\">";
                break;
            case 2:
                echo "<a href=\"tel:{$row['contact']}\">";
                break;
            case 3:
                echo "<a href=\"mailto:{$row['contact']}\">";
                break;
        }
//        echo "<a href=\"mailto:hugov@ipvc.pt\">";
            echo "<div class=\"contact-card rounded\">";
                echo "<div class=\"icon\">";
                    echo "<i class=\"{$row['icon']}\"></i>";
                    echo "<p>{$row['displayContact']}</p>";
                echo "</div>";
            echo "</div>";
        echo "</a>";
    }
}

function renderFooter($conn) {
    // Current Year
    $currYear = date("Y");

    $sql = "SELECT * FROM tblHeader";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "{$row['title']} &copy; $currYear";
}

function returnLanguageRows ($conn) {
    $sql = "SELECT * FROM tblLanguage";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

function renderLanguagesData($conn) {
    $sql = "SELECT l.name, l.level as levelId, ll.level
            FROM tblLanguage l, tblLanguageLevel ll
            WHERE l.level=ll.id ORDER BY levelId ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<ul>";
            echo "<li>{$row['name']} ({$row['level']})</li>";
        echo "</ul>";
    }
}