<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Differ\getDiffCalc;

class DifferTest extends TestCase
{
    public function testGetDiffCalc(): void
    {
        $testFirstPath = __DIR__ . "/fixtures/file1.json";
        $testSecondPath = __DIR__ . "/fixtures/file2.json";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTest1.json");

        $this->assertEquals($correctOutputFirstTest, getDiffCalc('json', $testFirstPath, $testSecondPath));

        $testThirdPath = __DIR__ . "/fixtures/file3.json";
        $testFourthPath = __DIR__ . "/fixtures/file4.json";
        $correctOutputSecondTest = file_get_contents(__DIR__ . "/fixtures/resultTest2.json");

        $this->assertEquals($correctOutputSecondTest, getDiffCalc('json', $testThirdPath, $testFourthPath));

        $testFifthPath = __DIR__ . "/fixtures/file5.yml";
        $testSixthPath = __DIR__ . "/fixtures/file6.yml";
        $correctOutputThirdTest = file_get_contents(__DIR__ . "/fixtures/resultTest3.yml");

        $this->assertEquals($correctOutputThirdTest, getDiffCalc('yml', $testFifthPath, $testSixthPath));
    }
}
