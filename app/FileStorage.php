<?php

namespace App;

class FileStorage
{
    public $countPrimals = 0;
    private $maxCountPrimals = 0;
    private $storedPrimals = [];
    private $filePath = 'app/storage/table.csv';

    public function __construct($filePath)
    {
        $this->filePath = $filePath;

        if (!file_exists($filePath)) {
            $file = fopen($filePath, 'w');
            fclose($file);
        }
        else {
            $file = fopen($filePath, 'r');
            $firstRow = fgetcsv($file);
            if ($firstRow !== false && !empty($firstRow)) {
                $this->storedPrimals = array_slice($firstRow, 1);
                $this->maxCountPrimals = count($firstRow)-1;
            }
        }
    }

    public function getMaxPrimalsCount(): int
    {
        return $this->maxCountPrimals;
    }

    public function getStoredPrimals(): array
    {
        return $this->storedPrimals;
    }

    public function getData($count = INF): array
    {
        $result = [];

        $handle = fopen($this->filePath, 'r');
        if ($handle !== false) {
            $row = 0;
            while (($data = fgetcsv($handle)) !== false && $row <= $count ) {
                if ($count !== INF) {
                    $data = array_slice($data, 0, ($count+1));
                }
                $result[] = $data;
                $row++;
            }
        }

        return $result;
    }

    public function storeTable($table)
    {
        $fp = fopen($this->filePath, 'w');

        foreach ($table as $row) {
            fputcsv($fp, $row);
        }
    }
}