<?php
require 'vendor/autoload.php';

use App\Primals;
use App\TablePrinter;
use App\TrianglePrinter;

$primals = new Primals();

echo 'Type the number of primals you want (10): ';
$input = trim(fgets(STDIN));

echo 'Enter the type of output: ';
$type = trim(fgets(STDIN));

// check the input before passing to the generate method
if (empty($input)) {
    $input = 10;
}
if ( preg_match('/^[0-9]+$/',$input)) {
    $count = (int) $input;
    $data = $primals->generateTable($count);

    if (!empty($type)) {
        if ($type == 'table') {
            $printer = new TablePrinter($data);
        }
        if ($type == 'triangle') {
            $printer = new TrianglePrinter($data);
        }

        if (isset($printer)) {
            $cellWidth = strlen((string) $primals->getLongestPrimal());
            $printer->print($cellWidth);
        }
        
    }
    else {
        fwrite(STDOUT, 'The type you\'ve entered is not supported!');
    }    
}
else {
    fwrite(STDOUT, 'You must enter a valid number!');
}