<?php

namespace App;

use App\FileStorage;

class Primals
{
    public $table;
    public $cellWidth = 3;
    public $storage;

    public function __construct()
    {
        $this->storage = new FileStorage('app/storage/table.csv');
    }

    public function isPrimal($number): int
    {
        for ($i = 2; $i < $number; $i++) {
            if ($number % $i == 0) {
                return 0;
            }
        }

        return 1;
    }

    public function getPrimals($count, $stored = []): array
    {
        $result = [];
        $currentNumber = 2;
        if (!empty($stored)) {
            $result = $stored;
            $currentNumber = end($stored)+1;
        }

        while (count($result) < $count) {
            if ($this->isPrimal($currentNumber)) {
                $result[] = $currentNumber;
            }
            $currentNumber++;
        }

        return $result;
    }

    public function setCellWidth($table): void
    {
        $finalRow = end($table);
        $finalCell = end($finalRow);
        $width = strlen((string) $finalCell)+1;

        $this->cellWidth = $width;
    }

    public function generateTable($count): array
    {
        $table = $this->storage->getData($count);
        $storedPrimalsCount = $this->storage->getMaxPrimalsCount();

        if ($storedPrimalsCount < $count) {
            $storedPrimals = $this->storage->getStoredPrimals();
            $primalNumbers = $this->getPrimals($count, $storedPrimals);
            $multiplicators = array_merge([1], $primalNumbers);
            
            $table[0] = array_merge(['#'], $primalNumbers);
            
            foreach($primalNumbers as $row_index => $p) {
                $tr = $row_index+1;
                $tableRow = [];
                $start = 0;
                if (isset($table[$tr]) && !empty($table[$tr])) {
                    $tableRow = $table[$tr];
                    $start = $storedPrimalsCount;
                }
                
                for ($i = $start; $i < count($multiplicators); $i++) {
                    $m = $multiplicators[$i];
                    $res = $p*$m;
                    $tableRow[] = $res;

                    $cellWidthNeeded = strlen((string) $res) + 1;
                    if ($cellWidthNeeded > $this->cellWidth) {
                        $this->cellWidth = $cellWidthNeeded;
                        print($cellWidthNeeded.'\r\n');
                    }
                }
    
                $table[$tr] = $tableRow;
            }

            $this->storage->storeTable($table);
        }

        $this->setCellWidth($table);
        
        return $table;
    }

    /**
     * Print out the table to STDOUT
     */
    public function printTable($table): void
    {
        $format = $this->getPrintFormat(count($table));
        foreach($table as $row) {
            fwrite(STDOUT, vsprintf($format, $row));
        }
        
    }

    public function getPrintFormat($cells): string
    {
        $i = 0;
        $format = '|';
        $mask = "%{$this->cellWidth}s|";
        while ($i < $cells) {
            $format .= $mask;
            $i++;
        }
        $format .= PHP_EOL;

        return $format;
    }
}