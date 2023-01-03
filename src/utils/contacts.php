<?php

function renderContactFilters() {
    $filterOptionOrder = array("ASC", "DESC");
    $filterOptionValue = array("name", "icon");

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

function printContact ($conn, $contact) {
    $sql = "SELECT * FROM tblContactType WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $contact['type'], PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<div class='contact-card'>";
        echo "<div class='icon'>";
            echo "<i class='{$row['icon']}'></i>";
        echo "</div>";
        echo "<p>{$contact['displayContact']}</p>";
        echo "<div class='contact-card__options'>";
            echo "<a href='edit_contact.php?id={$contact['id']}'><i class='fa-regular fa-pencil'></i></a>";
            echo "<a href='../../server/contacts.php?delete=1&id={$contact['id']}' onclick='return confirm(\"Are you sure you want to delete this?\")'><i class='fa-regular fa-trash'></i></a>";
        echo "</div>";
    echo "</div>";
}

function printContacts ($conn, $arr) {
    $count = 0;

    // Query for the Message State, prepare the statement, bind the parameters and execute the query
    $sql = "SELECT * FROM tblContact";

    // Order only (ASC or DESC)
    if(sizeof($arr) === 1) {
        if(isset($arr['orderDir'])) {
            $sql .= " ORDER BY id {$arr['orderDir']}";
        } else if (isset($arr['search']) && strcmp(trim($arr['search']), empty($_GET))) {
            $count = 1;
            $sql = "
                SELECT *
                FROM tblContact c, tblContactType ct
                WHERE c.type = ct.id AND (c.displayContact LIKE :search OR ct.name LIKE :search)";
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
    echo "<div id='contacts-wrapper'>";
        echo "<a href='add_contact.php'><div class='contact-card dashed'>";
            echo "<div class='icon'>";
                echo "<i class='fa-solid fa-plus'></i>";
                echo "<p>Add New Contact</p>";
            echo "</div>";
        echo "</div></a>";
    if($stmt->rowCount() > 0) {
        while($contact = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // print table row with data
            printContact($conn, $contact);
        }
    } else {
//        echo "<tr><td colspan=6>There are no records</td></tr>";
    }
    echo "</div>";
}

// Function to print all the possible types of contact to be added
function printContactType ($conn) {
    $sql = "SELECT id, name FROM tblContactType";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
    }
}

// Function to print options, selecting the one that the row has already been attributed
function printContactTypeById($conn, $type) {
    $sql = "SELECT * FROM tblContactType";
    $stmt =  $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row['id'] == $type) {
            echo "<option value='{$row['id']}' selected>";
        } else {
            echo "<option value='{$row['id']}'>";
        }
        echo $row['name'];
        echo "</option>";
    }
}

?>