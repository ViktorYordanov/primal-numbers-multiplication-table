<?php
require 'vendor/autoload.php';

use App\Primals;

$primals = new Primals();

echo 'Type the number of primals you want: ';
$input = trim(fgets(STDIN));
// check the input before passing to the generate method
if (preg_match('/^[0-9]+$/',$input)) {
    $count = (int) $input;
    $primals->printTable($primals->generateTable($count));
}
else {
    fwrite(STDOUT, 'You must enter a valid number!');
}