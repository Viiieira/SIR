<?php

// Function to print the roles of the selected user
function printUserRole ($conn, $userRole) {
    if($_SESSION['role'] == 1) {
        $sql = "SELECT * FROM tblRole";
    } else {
        $sql = "SELECT r.name FROM tblUser u, tblRole r WHERE u.role = r.id AND u.id = {$_SESSION['id']}";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($_SESSION['role'] == 1) {
        echo "<select name='role'>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['id'] == $userRole) { ?>
                <option value="<?php echo $row['id']; ?>" selected="selected">
            <?php } else { ?>
                <option value="<?php echo $row['id']; ?>">
            <?php } ?>
             <?php echo $row['name']; ?></option> ?>
        <?php }
        echo "</select>";
    } else {
        echo $stmt->fetch(PDO::FETCH_ASSOC)['name'];
    }
}

function printUserState ($conn, $userState) {
    if($_SESSION['role'] == 1) {
        $sql = "SELECT * FROM tblUserState";
    } else {
        $sql = "SELECT us.state FROM tblUser u, tblUserState us WHERE u.state = us.id AND u.id = {$_SESSION['id']}";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($_SESSION['role'] == 1) {
        echo "<select name='state'>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['id'] == $userState) { ?>
                <option value="<?php echo $row['id'];?>" selected="selected">
            <?php } else { ?>
                <option value="<?php echo $row['id']; ?>">
            <?php } ?>
            <?php echo $row['state']; ?>
            </option>
        <?php }
        echo "</select>";
    } else {
        echo $stmt->fetch(PDO::FETCH_ASSOC)['state'];
    }
}

// Function to render the filters to print the user
function renderUserFilters() {
    $filterOptionOrder = array("ASC", "DESC");
    $filterOptionValue = array("username", "role", "state");

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

function printUsers ($conn, $arr) {
    $count = 0;

    // Print all the users expect the one that is logged in
    $sql = "SELECT * FROM tblUser WHERE id<>{$_SESSION['id']}";

    // Order only (ASC or DESC)
    if(sizeof($arr) === 1) {
        if(isset($arr['orderDir'])) {
            $sql .= " ORDER BY id {$arr['orderDir']}";
        } else if (isset($arr['search']) && strcmp(trim($arr['search']), empty($_GET))) {
            $count = 1;
            $sql = "SELECT * FROM tblUser WHERE id<>{$_SESSION['id']} AND username LIKE :search OR email LIKE :search";
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
    }

    // Query all the users in the database
    $stmt = $conn->prepare($sql);
    if($count == 1) {
        $searchTerm = "%{$_GET['search']}%";
        $stmt->bindParam(":search", $searchTerm, PDO::PARAM_STR);
    }
    $stmt->execute();

    if($stmt->rowCount() !== 0) {
        while($user = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php if($_SESSION['role'] == 1) { ?>
            <form action="update_user.php?id=<?php echo $user['id']; ?>" method="POST" autocomplete="off" onsubmit="confirm('Are you sure you want to update this user?')">
            <?php } ?>
                <tr>
                    <td data-label="Username">
                        <img src="../../assets/images/<?php if(!empty($user['imgPath'])) { echo $user['imgPath']; } else { echo "user_notfound.png"; } ?>">
                        <?php if($user['state'] == 1) { ?>
                            <div class="user-state deactive"></div>
                        <?php } else if ($user['state'] == 2) { ?>
                            <div class="user-state active"></div>
                        <?php } ?>
                        <?php echo $user['username']; ?>
                    </td>
                    <td data-label="E-mail"><?php echo $user['email']; ?></td>
                    <td data-label="Role">
                        <?php printUserRole($conn, $user['role']); ?>
                    </td>
                    <td data-label="State">
                        <?php printUserState($conn, $user['state']); ?>
                    </td>
                    <td class="table__options">
                        <a href="details_user.php?id=<?php echo $user['id']; ?>">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <?php if($_SESSION['role'] == 1) { ?>
                            <button type="submit" name="editUserSubmit">
                            <i class="fa-regular fa-arrows-rotate"></i>
                        </button>
                        <?php }?>
                    </td>
                </tr>
            <?php if($_SESSION['role'] == 1) { ?>
            </form>
            <?php } ?>
        <?php }
    } else { ?>
        <tr>
            <td colspan="5">
                <?php if($count == 0) {
                    echo "There are no extra users.";
                } else {
                    echo "No users found with that expression. Please clear filters";
                } ?>
            </td>
        </tr>
    <?php }
}

// Add User Functions
function printUserRoleAdd ($conn) {
    $sql = "SELECT * FROM tblRole";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php }
}

function printUserStateAdd ($conn) {
    $sql = "SELECT * FROM tblUserState";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <option value="<?php echo $row['id']; ?>">
        <?php echo $row['state']; ?>
        </option>
    <?php }
}