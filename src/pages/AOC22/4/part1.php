<?php

// Variables
// Put the file lines into an array
$file = file("example.txt");
$leftPart = array();
$rightPart = array();

// Get both left and right part of each line
for($i = 0; $i < sizeof($file); $i++) {
    $file[$i] = trim($file[$i]);
    $sep = strpos($file[$i], ",");
    $sepIni = stripos($file[$i], "-");
    $sepFim = strrpos($file[$i], "-");

    $leftPart[$i] = substr($file[$i], 0, $sep);
    $rightPart[$i] = substr($file[$i], -$sep++);

    // Get both numbers from each parts
    $leftPartNumbers = array(array());
    $rightPartNumbers = array(array());

    $leftPartNumbers[$i][0] = substr($leftPart[$i], 0, $sepIni);
    $rightPartNumbers[$i][1] = substr($rightPart[$i], -$sepFim++);
}

print_r($leftPartNumbers);

?>