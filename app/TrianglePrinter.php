<?php

namespace App;
use App\Printer;

class TrianglePrinter extends Printer
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function print(int $cellWidth = null): void
    {
        $table = $this->data;
        foreach($table as $k => $row) {
            $count = $k+1;
            $format = $this->getPrintFormat($count, $cellWidth);
            $sub_data = array_slice($row, 0, $count);
            fwrite(STDOUT, vsprintf($format, $sub_data));
        }
    }
}