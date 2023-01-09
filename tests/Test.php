<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class Test extends TestCase
{
    /**
    * @dataProvider provideFormatData
    */
    public function testDefault($format): void
    {
        $firstPath = __DIR__ . "/fixtures/file1.{$format}";
        $secondPath = __DIR__ . "/fixtures/file2.{$format}";
        $correctOutput = file_get_contents(__DIR__ . "/fixtures/resultTestStylish");
        $this->assertEquals($correctOutput, genDiff($firstPath, $secondPath));
    }

    /**
    * @dataProvider provideFormatData
    */
    public function testStylish($format): void
    {
        $testStylishPath1 = __DIR__ . "/fixtures/file1.{$format}";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.{$format}";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTestStylish");
        $this->assertEquals($correctOutputFirstTest, genDiff($testStylishPath1, $testStylishPath2, 'stylish'));
    }

    /**
    * @dataProvider provideFormatData
    */
    public function testPlain($format): void
    {
        $testPlainPath1 = __DIR__ . "/fixtures/file1.{$format}";
        $testStylishPath2 = __DIR__ . "/fixtures/file2.{$format}";
        $correctOutputThirdTest = file_get_contents(__DIR__ . "/fixtures/resultTestPlain");
        $this->assertEquals($correctOutputThirdTest, genDiff($testPlainPath1, $testStylishPath2, 'plain'));
    }

    /**
    * @dataProvider provideFormatData
    */
    public function testJson($format): void
    {
        $testJsonPath1 = __DIR__ . "/fixtures/file1.{$format}";
        $testJsonPath2 = __DIR__ . "/fixtures/file2.{$format}";
        $correctOutputFourthTest = file_get_contents(__DIR__ . "/fixtures/resultTestJson");
        $this->assertEquals($correctOutputFourthTest, genDiff($testJsonPath1, $testJsonPath2, 'json'));
    }

    public function provideFormatData(): array
    {
        return [
            ['json'],
            ['yml']
        ];
    }
}
