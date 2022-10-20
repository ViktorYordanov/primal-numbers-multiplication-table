<?php

namespace App;

class Primals
{
    public $table;
    public $cellWidth = 3;

    public function isPrimal($number): int
    {
        for ($i = 2; $i < $number; $i++) {
            if ($number % $i == 0) {
                return 0;
            }
        }

        return 1;
    }

    public function getPrimals($count): array
    {
        $result = [];
        $currentNumber = 2;

        while (count($result) < $count) {
            if ($this->isPrimal($currentNumber)) {
                $result[] = $currentNumber;
            }
            $currentNumber++;
        }

        return $result;
    }

    public function generateTable($count): array
    {
        $this->table = [];
        $primalNumbers = $this->getPrimals($count);
        $multiplicators = array_merge([1], $primalNumbers);
        $table[] = array_merge(['#'], $primalNumbers);

        foreach($primalNumbers as $p) {
            $tableRow = [];
            foreach($multiplicators as $m) {
                $tableRow[] = $p*$m;
            }

            $table[] = $tableRow;
        }

        return $table;
    }

    public function printTable()
    {
        fwrite(STDOUT, 'Printing the table');
    }
}