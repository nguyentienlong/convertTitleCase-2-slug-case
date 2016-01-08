<?php
/**
 * This file aims to convert titleCase in blade file to slug-case
 * 
 */

$file = $argv[1];

$fileContent = fopen($file, "r");
$output = "";

if($fileContent) {
    while (($line = fgets($fileContent)) !== false) {
 	//process the line read
	$newLine = strtolower(preg_replace('#([a-zA-Z])(?=[A-Z])#', '$1-', $line));

	$output .= $newLine;
    }	    
} else {
    //handle error here
}

file_put_contents("output_blade.txt", $output);
