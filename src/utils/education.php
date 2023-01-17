<?php

function renderEducationFilters() {
    $filterOptionOrder = array("ASC", "DESC");
    $filterOptionValue = array("schoolAcronym", "dtStart", "dtEnd", "level");

    ?>
    <div class="filter__options-title">
        Order By
        <select id="filter-options-order" name="orderDir">
            <?php for($i = 0; $i < sizeof($filterOptionOrder); $i++) {
                echo "<option value='$filterOptionOrder[$i]'>";
                echo ucfirst(strtolower($filterOptionOrder[$i])) . "endant";
                echo "</option>";
            } ?>
        </select>
    </div>
    <?php for($i = 0; $i < sizeof($filterOptionValue); $i++) { ?>
        <div class="filter__option">
            <input type="checkbox" name="<?php echo $filterOptionValue[$i]; ?>" id="">
            <span><?php echo ucfirst($filterOptionValue[$i]); ?></span>
        </div>
    <?php }
}

function printEducation ($conn, $arr) {
    $count = 0;

    // Query for the Message State, prepare the statement, bind the parameters and execute the query
    $sql = "
        SELECT id, schoolFullName, schoolAcronym, dtStart, dtEnd, level
        FROM tblEducation";

    // Order only (ASC or DESC)
    if(sizeof($arr) === 1) {
        if(isset($arr['orderDir'])) {
            $sql .= " ORDER BY id {$arr['orderDir']}";
        } else if (isset($arr['search']) && strcmp(trim($arr['search']), empty($_GET))) {
            $count = 1;
            $sql = "
                SELECT id, schoolFullName, schoolAcronym, dtStart, dtEnd, level
                FROM tblEducation
                WHERE schoolAcronym LIKE :search OR dtStart LIKE :search OR dtEnd LIKE :search OR level LIKE :search";
        }
    } else if (sizeof($arr) >= 2){
        $sql .= " ORDER BY ";
        // Create an array to store the filters
        $filters = array_keys($arr);

        for($i = 1; $i < sizeof($filters); $i++) {
            $sql .= "$filters[$i]";
            if($i !== sizeof($filters)-1) {
                $sql .= ", ";
            }
        }
        $sql .= " {$arr['orderDir']}";
    }

    $stmt = $conn->prepare($sql);
    if($count == 1) {
        $searchTerm = "%{$_GET['search']}%";
        $stmt->bindParam(":search", $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();

    // Verify if the query returned any results
    if($stmt->rowCount() > 0) {
        while($education = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // print table row with data
            echo "<tr>";
            echo "<td data-label='School Name'>{$education['schoolFullName']}</td>";
            echo "<td data-label='School Acronym'>{$education['schoolAcronym']}</td>";
            echo "<td data-label='Date'>{$education['dtStart']}/";
            echo ($education['dtEnd'] !== 0) ? $education['dtEnd'] : "Present";
            echo "</td>";
            echo "<td data-label='Level'>{$education['level']}</td>";
            echo "<td data-label='Options' class='table__options'>";
            echo "<a href='edit_education.php?id={$education['id']}'><i class='fa-regular fa-pencil'></i></a>";
            echo "<a onclick=\"return confirm('Are you sure you want to delete this?')\" href='../../server/education.php?delete=1&id={$education['id']}'><i class='fa-regular fa-trash'></i></a>";
            echo "</td>";
            echo "<tr>";
        }
    } else {
        echo "<tr><td colspan=6>There are no records</td></tr>";
    }
}

// Function to verify if the education with that id exists or not
function verifyIssetEducation($conn, $id) {
    $sql = "SELECT * FROM tblEducation WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount();
}

function getEducationById($conn, $id) {
    $sql = "SELECT * FROM tblEducation WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>