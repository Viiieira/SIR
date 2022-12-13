<?php

// Function to print a normal array
function printArray($array) {
    for($i = 0; $i < sizeof($array); $i++) {
        echo "[$i] - [" . $array[$i] . "]<br>";
    }
}

// Function to print a bidimensional array
function printBiArray ($array) {
    for ($i = 0; $i < sizeof($array); $i++) {
        for($j = 0; $j < sizeof($array[$i]); $j++) {
            echo "[$i][$j] - [" . $array[$i][$j] . "]<br>";
        }
    }
}

?>