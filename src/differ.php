<?php

namespace Differ\Differ;

use function Functional\flatten;
use function DiffCalc\Parses\pathToArray;
use function DiffCalc\Formatter\getFormatted;
use function Differ\Build\getBuildDiff;

function genDiff(string $firstPath, string $secondPath, string $formatOutput = 'stylish')
{
    $contentFromFirstFile = pathToArray(file_get_contents($firstPath), $firstPath);
    $contentFromSecondFile = pathToArray(file_get_contents($secondPath), $secondPath);

    $buildDiff = getBuildDiff($contentFromFirstFile, $contentFromSecondFile);

    return getFormatted($buildDiff, $formatOutput);
}
