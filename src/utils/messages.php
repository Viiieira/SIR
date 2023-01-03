<?php

function renderMessageFilters() {
    $filterOptionOrder = array("ASC", "DESC");
    $filterOptionValue = array("name", "email", "state");

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

function printMessageUserReply($conn, $idUser) {
    $sql = "SELECT * FROM tblUser WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $idUser, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['username'];
}

// Function to return the Message state when given the id of the message
function printMessageState($conn, $idMessage) {
    $class = $icon = "";

    $sql = "
        SELECT *
        FROM tblMessageState ms, tblMessage m
        WHERE ms.id = m.state AND m.id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $idMessage, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    switch($row['state']) {
        case 1:
            $class = "new";
            $icon = "fa-circle-exclamation";
            break;
        case 2:
            $class = "replied";
            $icon = "fa-circle-check";
            break;
        case 3:
            $class = "spam";
            $icon = "fa-bug";
            break;
    }
    echo "<div class='message-state $class'><i class='fa-solid $icon'></i><span>" . ucfirst($class) . "</span></div>";
}

function printMessages ($conn, $arr) {
    $count = 0;

    // Query for the Message State, prepare the statement, bind the parameters and execute the query
    $sql = "SELECT * FROM tblMessage";

    // Order only (ASC or DESC)
    if(sizeof($arr) === 1) {
        if(isset($arr['orderDir'])) {
            $sql .= " ORDER BY id {$arr['orderDir']}";
        } else if (isset($arr['search']) && strcmp(trim($arr['search']), empty($_GET))) {
            $count = 1;
            $sql = "
                SELECT *
                FROM tblMessage
                WHERE name LIKE :search OR email LIKE :search";
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
        while($message = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // print table row with data
            echo "<tr>";
            echo "<td data-label='Name'>{$message['name']}</td>";
            echo "<td data-label='E-mail'>" . $message['email'] . "</td>";
            echo "<td data-label='Message'>" . $message['message'] . "</td>";
            echo "<td data-label='State'>";
            switch($message['state']) {
                case 1:
                    $class = "new";
                    $icon = "fa-circle-exclamation";
                    break;
                case 2:
                    $class = "replied";
                    $icon = "fa-circle-check";
                    break;
                case 3:
                    $class = "spam";
                    $icon = "fa-bug";
                    break;
            }
            echo "<div class='message-state $class'><i class='fa-solid $icon'></i><span>" . ucfirst($class) . "</span></div>";
            echo "</span></div></td>";
            echo "<td data-label='Replied'>";
            if(!empty($message['idUserReply'])) {
                echo $message['name'];
            }
            echo "</td>";
            echo "<td data-label='Options' class='table__options'>";
                echo "<a href='details_message.php?id={$message['id']}'><i class='fa-regular fa-eye'></i></a>";
            if(strcmp($class, "new") == 0) {
                echo "<a href='reply_message.php?id={$message['id']}'><i class='fa-regular fa-paper-plane'></i></a>";
            } else if (strcmp($class, "spam") == 0) {
                echo "<a href='delete_message.php?id={$message['id']}'><i class='fa-regular fa-trash'></i></a>";
            }
            echo "</td>";
        }
    } else {
        echo "<tr><td colspan=6>There are no records</td></tr>";
    }
}

?>