<?php

use App\FileStorage;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    protected function setUp(): void
    {
        $structure = [
            'app' => [
                'storage' => [
                    'existing.csv' => "#,2,3,5\n2,4,6,10\n3,6,9,15\n5,10,15,25"
               ]
            ]
        ];

        $this->root   = vfsStream::setup('root',null,$structure);
    }

    public function testCreateStorageFile(): void
    {
        $path = $this->root->url() . '/app/storage/new.csv';

        $this->assertFileDoesNotExist($path);

        $storage = new FileStorage($path);

        $this->assertFileExists($path);
    }

    public function testGetStorageFileData(): void
    {
        $storage = new FileStorage($this->root->url() . '/app/storage/existing.csv');

        $expected = [
            ['#',2,3,5],
            [2,4,6,10],
            [3,6,9,15],
            [5,10,15,25]
        ];

        $this->assertEquals($expected, $storage->getData());
    }

    public function testGetStoredMaxPrimalsCount(): void
    {
        $storage = new FileStorage($this->root->url() . '/app/storage/existing.csv');

        $this->assertEquals(3, $storage->getMaxPrimalsCount());
    }

    public function testGetStoredPrimals(): void
    {
        $storage = new FileStorage($this->root->url() . '/app/storage/existing.csv');

        $this->assertEquals([2,3,5], $storage->getStoredPrimals());
    }

    public function testGetDataFromStorageForLowerPrimalsCount(): void
    {
        $storage = new FileStorage($this->root->url() . '/app/storage/existing.csv');

        $expected = [
            ['#',2,3],
            [2,4,6],
            [3,6,9]
        ];

        $this->assertEquals($expected, $storage->getData(2));
    }
}