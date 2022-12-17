<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Differ\getDiffCalc;

class Test extends TestCase
{
    public function testGetDiffCalc(): void
    {
        $testFirstPath = __DIR__ . "/fixtures/file1.json";
        $testSecondPath = __DIR__ . "/fixtures/file2.json";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTest1.json"); 
        $this->assertEquals($correctOutputFirstTest, getDiffCalc($testFirstPath, $testSecondPath, 'stylish'));
        
        $testThirdPath = __DIR__ . "/fixtures/file3.yml";
        $testFourthPath = __DIR__ . "/fixtures/file4.yml";
        $correctOutputSecondTest = file_get_contents(__DIR__ . "/fixtures/resultTest2.yml");
        $this->assertEquals($correctOutputSecondTest, getDiffCalc($testThirdPath, $testFourthPath, 'stylish'));
    }
}
