<?php

function renderLanguageFilters() {
    $filterOptionOrder = array("ASC", "DESC");
    $filterOptionValue = array("name", "level");

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

function printLanguageName ($conn, $name) {
    $nationalities = array(
        "Afghan",
        "Albanian",
        "Algerian",
        "American",
        "Andorran",
        "Angolan",
        "Antiguans",
        "Argentinean",
        "Armenian",
        "Australian",
        "Austrian",
        "Azerbaijani",
        "Bahamian",
        "Bahraini",
        "Bangladeshi",
        "Barbadian",
        "Barbudans",
        "Batswana",
        "Belarusian",
        "Belgian",
        "Belizean",
        "Beninese",
        "Bhutanese",
        "Bolivian",
        "Bosnian",
        "Brazilian",
        "British",
        "Bruneian",
        "Bulgarian",
        "Burkinabe",
        "Burmese",
        "Burundian",
        "Cambodian",
        "Cameroonian",
        "Canadian",
        "Cape Verdean",
        "Central African",
        "Chadian",
        "Chilean",
        "Chinese",
        "Colombian",
        "Comoran",
        "Congolese",
        "Costa Rican",
        "Croatian",
        "Cuban",
        "Cypriot",
        "Czech",
        "Danish",
        "Djibouti",
        "Dominican",
        "Dutch",
        "East Timorese",
        "Ecuadorean",
        "Egyptian",
        "Emirian",
        "English",
        "Equatorial Guinean",
        "Eritrean",
        "Estonian",
        "Ethiopian",
        "Fijian",
        "Filipino",
        "Finnish",
        "French",
        "Gabonese",
        "Gambian",
        "Georgian",
        "German",
        "Ghanaian",
        "Greek",
        "Grenadian",
        "Guatemalan",
        "Guinea-Bissauan",
        "Guinean",
        "Guyanese",
        "Haitian",
        "Herzegovinian",
        "Honduran",
        "Hungarian",
        "I-Kiribati",
        "Icelander",
        "Indian",
        "Indonesian",
        "Iranian",
        "Iraqi",
        "Irish",
        "Israeli",
        "Italian",
        "Ivorian",
        "Jamaican",
        "Japanese",
        "Jordanian",
        "Kazakhstani",
        "Kenyan",
        "Kittian and Nevisian",
        "Kuwaiti",
        "Kyrgyz",
        "Laotian",
        "Latvian",
        "Lebanese",
        "Liberian",
        "Libyan",
        "Liechtensteiner",
        "Lithuanian",
        "Luxembourger",
        "Macedonian",
        "Malagasy",
        "Malawian",
        "Malaysian",
        "Maldivan",
        "Malian",
        "Maltese",
        "Marshallese",
        "Mauritanian",
        "Mauritian",
        "Mexican",
        "Micronesian",
        "Moldovan",
        "Monacan",
        "Mongolian",
        "Moroccan",
        "Mosotho",
        "Motswana",
        "Mozambican",
        "Namibian",
        "Nauruan",
        "Nepalese",
        "New Zealander",
        "Nicaraguan",
        "Nigerian",
        "Nigerien",
        "North Korean",
        "Northern Irish",
        "Norwegian",
        "Omani",
        "Pakistani",
        "Palauan",
        "Panamanian",
        "Papua New Guinean",
        "Paraguayan",
        "Peruvian",
        "Polish",
        "Portuguese",
        "Qatari",
        "Romanian",
        "Russian",
        "Rwandan",
        "Saint Lucian",
        "Salvadoran",
        "Samoan",
        "San Marinese",
        "Sao Tomean",
        "Saudi",
        "Scottish",
        "Senegalese",
        "Serbian",
        "Seychellois",
        "Sierra Leonean",
        "Singaporean",
        "Slovakian",
        "Slovenian",
        "Solomon Islander",
        "Somali",
        "South African",
        "South Korean",
        "Spanish",
        "Sri Lankan",
        "Sudanese",
        "Surinamer",
        "Swazi",
        "Swedish",
        "Swiss",
        "Syrian",
        "Taiwanese",
        "Tajik",
        "Tanzanian",
        "Thai",
        "Togolese",
        "Tongan",
        "Trinidadian or Tobagonian",
        "Tunisian",
        "Turkish",
        "Tuvaluan",
        "Ugandan",
        "Ukrainian",
        "Uruguayan",
        "Uzbekistani",
        "Venezuelan",
        "Vietnamese",
        "Welsh",
        "Yemenite",
        "Zambian",
        "Zimbabwean"
    );

    foreach($nationalities as $nationality) {
        if(strcmp($nationality, $name) == 0) {
            echo "<option value='{$nationality}' selected>";
        } else {
            echo "<option value='{$nationality}'>";
        }
        echo "$nationality</option>";
    }
}

function printLanguageLevel ($conn, $level) {
    $sql = "SELECT * FROM tblLanguageLevel";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row['id'] == $level) {
            echo "<option value='{$row['id']}' selected>";
        } else {
            echo "<option value='{$row['id']}'>";
        }
        echo $row['level'];
        echo "</option>";
    }
}

function printLanguages ($conn, $arr) {
    $count = 0;

    // Query for the Message State, prepare the statement, bind the parameters and execute the query
    $sql = "
        SELECT l.id, l.name, l.level as levelid, ll.level
        FROM tblLanguage l, tblLanguageLevel ll
        WHERE l.level = ll.id
    ";

    // Order only (ASC or DESC)
    if(sizeof($arr) === 1) {
        if(isset($arr['orderDir'])) {
            $sql .= " ORDER BY l.id {$arr['orderDir']}";
        } else if (isset($arr['search']) && strcmp(trim($arr['search']), empty($_GET))) {
            $count = 1;
            $sql = "
                SELECT l.id, l.name, l.level, ll.level AS levelName
                FROM tblLanguage l, tblLanguageLevel ll
                WHERE l.level = ll.id AND (l.name LIKE :search OR ll.level LIKE :search)
            ";
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
        while($language = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // print table row with data
            echo "<form method=\"POST\" action=\"../../server/languages.php\">";
                echo "<tr>";
                    echo "<input type='hidden' name='id' value='{$language['id']}'>";
                    echo "<td data-label='Name'>";
                        echo "<select name='name'>";
                            printLanguageName($conn, $language['name']);
                        echo "</select>";
                    echo "</td>";
                    echo "<td data-label='Level'>";
                        echo "<select name='level'>";
                            printLanguageLevel($conn, $language['levelid']);
                        echo "</select>";
                    echo "</td>";
                    echo "<td class='table__options'>";
                        echo "<button type='submit' name='editLanguageSubmit'>";
                            echo '<i class="fa-regular fa-pencil"></i>';
                        echo "</button>";
                        echo "<a onclick='confirm(\"Are you sure you want to delete this language?\")' href='../../server/languages.php?delete=1&id={$language['id']}'>";
                                echo '<i class="fa-regular fa-trash"></i>';
                        echo "</a>";
                    echo "</td>";
                echo "</tr>";
            echo "</form>";
        }
    } else {
        echo "<tr><td colspan=6>There are no records</td></tr>";
    }
}

function renderNewLanguageLevels ($conn) {
    $sql = "SELECT * FROM tblLanguageLevel";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$row['id']}'>{$row['level']}</option>";
    }
}

function renderNewLanguageName ($conn) {
    $nationalities = array(
        "Afghan",
        "Albanian",
        "Algerian",
        "American",
        "Andorran",
        "Angolan",
        "Antiguans",
        "Argentinean",
        "Armenian",
        "Australian",
        "Austrian",
        "Azerbaijani",
        "Bahamian",
        "Bahraini",
        "Bangladeshi",
        "Barbadian",
        "Barbudans",
        "Batswana",
        "Belarusian",
        "Belgian",
        "Belizean",
        "Beninese",
        "Bhutanese",
        "Bolivian",
        "Bosnian",
        "Brazilian",
        "British",
        "Bruneian",
        "Bulgarian",
        "Burkinabe",
        "Burmese",
        "Burundian",
        "Cambodian",
        "Cameroonian",
        "Canadian",
        "Cape Verdean",
        "Central African",
        "Chadian",
        "Chilean",
        "Chinese",
        "Colombian",
        "Comoran",
        "Congolese",
        "Costa Rican",
        "Croatian",
        "Cuban",
        "Cypriot",
        "Czech",
        "Danish",
        "Djibouti",
        "Dominican",
        "Dutch",
        "East Timorese",
        "Ecuadorean",
        "Egyptian",
        "Emirian",
        "English",
        "Equatorial Guinean",
        "Eritrean",
        "Estonian",
        "Ethiopian",
        "Fijian",
        "Filipino",
        "Finnish",
        "French",
        "Gabonese",
        "Gambian",
        "Georgian",
        "German",
        "Ghanaian",
        "Greek",
        "Grenadian",
        "Guatemalan",
        "Guinea-Bissauan",
        "Guinean",
        "Guyanese",
        "Haitian",
        "Herzegovinian",
        "Honduran",
        "Hungarian",
        "I-Kiribati",
        "Icelander",
        "Indian",
        "Indonesian",
        "Iranian",
        "Iraqi",
        "Irish",
        "Israeli",
        "Italian",
        "Ivorian",
        "Jamaican",
        "Japanese",
        "Jordanian",
        "Kazakhstani",
        "Kenyan",
        "Kittian and Nevisian",
        "Kuwaiti",
        "Kyrgyz",
        "Laotian",
        "Latvian",
        "Lebanese",
        "Liberian",
        "Libyan",
        "Liechtensteiner",
        "Lithuanian",
        "Luxembourger",
        "Macedonian",
        "Malagasy",
        "Malawian",
        "Malaysian",
        "Maldivan",
        "Malian",
        "Maltese",
        "Marshallese",
        "Mauritanian",
        "Mauritian",
        "Mexican",
        "Micronesian",
        "Moldovan",
        "Monacan",
        "Mongolian",
        "Moroccan",
        "Mosotho",
        "Motswana",
        "Mozambican",
        "Namibian",
        "Nauruan",
        "Nepalese",
        "New Zealander",
        "Nicaraguan",
        "Nigerian",
        "Nigerien",
        "North Korean",
        "Northern Irish",
        "Norwegian",
        "Omani",
        "Pakistani",
        "Palauan",
        "Panamanian",
        "Papua New Guinean",
        "Paraguayan",
        "Peruvian",
        "Polish",
        "Portuguese",
        "Qatari",
        "Romanian",
        "Russian",
        "Rwandan",
        "Saint Lucian",
        "Salvadoran",
        "Samoan",
        "San Marinese",
        "Sao Tomean",
        "Saudi",
        "Scottish",
        "Senegalese",
        "Serbian",
        "Seychellois",
        "Sierra Leonean",
        "Singaporean",
        "Slovakian",
        "Slovenian",
        "Solomon Islander",
        "Somali",
        "South African",
        "South Korean",
        "Spanish",
        "Sri Lankan",
        "Sudanese",
        "Surinamer",
        "Swazi",
        "Swedish",
        "Swiss",
        "Syrian",
        "Taiwanese",
        "Tajik",
        "Tanzanian",
        "Thai",
        "Togolese",
        "Tongan",
        "Trinidadian or Tobagonian",
        "Tunisian",
        "Turkish",
        "Tuvaluan",
        "Ugandan",
        "Ukrainian",
        "Uruguayan",
        "Uzbekistani",
        "Venezuelan",
        "Vietnamese",
        "Welsh",
        "Yemenite",
        "Zambian",
        "Zimbabwean"
    );

    foreach($nationalities as $nationality) {
        echo "<option value='{$nationality}'>$nationality</option>";
    }
}

?>


