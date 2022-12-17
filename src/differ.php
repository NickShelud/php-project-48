<?php

namespace DiffCalc\Differ;

use function Functional\flatten;
use function DiffCalc\Parses\pathToArray;
use function DiffCalc\Formatter\arrayToString;
use function DiffCalc\Formatter\getFormatted;
use function Differ\Build\getBuildDiff;

function getDiffCalc(string $firstPath, string $secondPath, string $formatOutput = 'stylish')
{
    $contentFromFirstFile = pathToArray($firstPath);
    $contentFromSecondFile = pathToArray($secondPath);

    $buildDiff = getBuildDiff($contentFromFirstFile, $contentFromSecondFile);

    return getFormatted($buildDiff, $formatOutput);
}
