<?php

namespace UnitTest\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Differ\getBuildDiff;

class Test extends TestCase
{
    public function testGetDiffCalc(): void
    {
        $testFirstPath = __DIR__ . "/fixtures/file1.json";
        $testSecondPath = __DIR__ . "/fixtures/file2.json";
        $correctOutputFirstTest = file_get_contents(__DIR__ . "/fixtures/resultTest1.json");

        $this->assertEquals($correctOutputFirstTest, getBuildDiff($testFirstPath, $testSecondPath, 'json'));

        $testThirdPath = __DIR__ . "/fixtures/file3.json";
        $testFourthPath = __DIR__ . "/fixtures/file4.json";
        $correctOutputSecondTest = file_get_contents(__DIR__ . "/fixtures/resultTest2.json");

        $this->assertEquals($correctOutputSecondTest, getBuildDiff($testThirdPath, $testFourthPath, 'json'));

        $testFifthPath = __DIR__ . "/fixtures/file5.yml";
        $testSixthPath = __DIR__ . "/fixtures/file6.yml";
        $correctOutputThirdTest = file_get_contents(__DIR__ . "/fixtures/resultTest3.yml");

        $this->assertEquals($correctOutputThirdTest, getBuildDiff($testFifthPath, $testSixthPath, 'yml'));

       //$testSeventhPath = __DIR__ . "/fixtures/file7.json";
       //$testEighthPath = __DIR__ . "/fixtures/file8.json";
       //$correctOutputFourthTest = file_get_contents(__DIR__ . "/fixtures/resultTest4.json");

       //$this->assertEquals($correctOutputFourthTest, getBuildDiff('yml', $testSeventhPath, $testEighthPath));
       //
       //$testNinthPath = __DIR__ . "/fixtures/file9.yml";
       //$testTenthPath = __DIR__ . "/fixtures/file10.yml";
       //$correctOutputFifthTest = file_get_contents(__DIR__ . "/fixtures/resultTest5.yml");

       //$this->assertEquals($correctOutputFifthTest, getBuildDiff('yml', $testNinthPath, $testTenthPath));
    }
}
