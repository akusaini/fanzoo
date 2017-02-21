<?php

//Script is made for both command line and web browser.
//For command line "php series.php B".
//For web browser url is http://localhost/series.php?arg1=B
//Taking the argument after checking from where the script is called.
if (PHP_SAPI === 'cli') {
    $argument = $argv[1];
} else {
    $argument = $_GET['arg1'];
}

//Checking the value is numeric or character value. 
if (is_numeric($argument)) {
    $evaluatedValue = $argument;
    $asciiOfCharacter = 90;
} else {
    $asciiOfCharacter = ord($argument);
    if ($asciiOfCharacter < 65 || $asciiOfCharacter > 90) {
        exit('The value given is out of the range of script.');
    }
}

$i = 65;
$ans = 0;
$printed = 0;
//Calculating the value.
while ($i <= $asciiOfCharacter) {
    $ans = $ans * 2 + ($i - 64);
    if (is_numeric($argument) && $ans == $evaluatedValue) {
        //Display the output of the numeric input. 
        echo chr($i);
        $printed = 1;
        break;
    }
    $i++;
}

//Display the out put of the character input. 
if (!is_numeric($argument))
    echo $ans;

//Checking for if the value is present in series or not.
if ($printed == 0 && is_numeric($argument))
    echo 'The numeric input given to the script in not present in the series.';
?>


