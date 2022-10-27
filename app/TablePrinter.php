<?php

namespace App;
use App\Printer;

class TablePrinter extends Printer
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function print(int $cellWidth): void
    {
        $table = $this->data;
        $format = $this->getPrintFormat(count($table), $cellWidth);
        foreach($table as $row) {
            fwrite(STDOUT, vsprintf($format, $row));
        }
    }

}