<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class Test extends TestCase
{
    public function testDefault(): void
    {
        $firstPath = __DIR__ . "/fixtures/file1.json";
        $secondPath = __DIR__ . "/fixtures/file2.json";
        $correctOutput = file_get_contents(__DIR__ . "/fixtures/resultTest1.json");
        $this->assertEquals($correctOutput, genDiff($firstPath, $secondPath));
    }

    public function testStylish(): void
    {
        $testStylishPath1 = __DIR__ . "/fixtures/file1.json";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.json";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTest1.json");
        $this->assertEquals($correctOutputFirstTest, genDiff($testStylishPath1, $testStylishPath2, 'stylish'));

        $testStylishPath3 = __DIR__ . "/fixtures/file3.yml";
        $testStylishPath4 = __DIR__ . "/fixtures/file4.yml";
        $correctOutputSecondTest = file_get_contents(__DIR__ . "/fixtures/resultTest2.yml");
        $this->assertEquals($correctOutputSecondTest, genDiff($testStylishPath3, $testStylishPath4, 'stylish'));
    }
    
    public function testPlain(): void
    {
        $testPlainPath1 = __DIR__ . "/fixtures/file1.json";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.json";
        $correctOutputThirdTest = file_get_contents(__DIR__ . "/fixtures/resultTest3.txt");
        $this->assertEquals($correctOutputThirdTest, genDiff($testPlainPath1, $testStylishPath2, 'plain'));
    }

    public function testJson(): void
    {
        $testJsonPath1 = __DIR__ . "/fixtures/file1.json";
        $testJsonPath2 = __DIR__ . "/fixtures/file2.json";
        $correctOutputFourthTest = file_get_contents(__DIR__ . "/fixtures/resultTest4.json");
        $this->assertEquals($correctOutputFourthTest, genDiff($testJsonPath1, $testJsonPath2, 'json'));
    }
}
