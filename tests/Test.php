<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Differ\getDiffCalc;

class Test extends TestCase
{
    public function testGetDiffCalc(): void
    {
        $testStylishPath1 = __DIR__ . "/fixtures/file1.json";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.json";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTest1.json");
        $this->assertEquals($correctOutputFirstTest, getDiffCalc($testStylishPath1, $testStylishPath2, 'stylish'));

        $testStylishPath3 = __DIR__ . "/fixtures/file3.yml";
        $testStylishPath4 = __DIR__ . "/fixtures/file4.yml";
        $correctOutputSecondTest = file_get_contents(__DIR__ . "/fixtures/resultTest2.yml");
        $this->assertEquals($correctOutputSecondTest, getDiffCalc($testStylishPath3, $testStylishPath4, 'stylish'));

        $testPlainPath1 = __DIR__ . "/fixtures/file1.json";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.json";
        $correctOutputThirdTest = file_get_contents(__DIR__ . "/fixtures/resultTest3.txt");
        $this->assertEquals($correctOutputThirdTest, getDiffCalc($testPlainPath1, $testStylishPath2, 'plain'));
    }
}
