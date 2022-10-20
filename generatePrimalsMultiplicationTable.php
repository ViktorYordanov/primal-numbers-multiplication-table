<?php
require 'vendor/autoload.php';

use App\Primals;

$primals = new Primals();

echo 'Type the number of primals you want: ';
$input = fgets(STDIN);
// check the input before passing to the generate method

$primals->generateTable(4);
$primals->printTable();
