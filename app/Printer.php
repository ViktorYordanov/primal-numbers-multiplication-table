<?php

namespace App;

class Printer
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;    
    }
  
    public function getPrintFormat(int $cells, int $cellWidth): string
    {
        $i = 0;
        $format = '|';
        $mask = "%{$cellWidth}s|";
        while ($i < $cells) {
            $format .= $mask;
            $i++;
        }
        $format .= PHP_EOL;

        return $format;
    }
}