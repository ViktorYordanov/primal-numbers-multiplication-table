<?php

use App\Primals;
use PHPUnit\Framework\TestCase;

class PrimalsTest extends TestCase
{
    public function testIsPrimal() {
        $primals = new Primals();
        $isPrimal = $primals->isPrimal(7);

        $this->assertIsInt($isPrimal);
        $this->assertEquals(1, $isPrimal);
    }

    public function testGetPrimals() {
        $primals = new Primals();
        $expected = [2,3,5,7,11];
        $result = $primals->getPrimals(count($expected));
        
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    public function testGenerateTable() {
        $primals = new Primals();
        $expected = [
            ['#',2,3,5,7,11],
            [2,4,6,10,14,22],
            [3,6,9,15,21,33],
            [5,10,15,25,35,55],
            [7,14,21,35,49,77],
            [11,22,33,55,77,121]
        ];
        $result = $primals->generateTable(5);
        
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }
}