<?php

namespace DiffCalc\Formatter;

use function DiffCalc\Formatter\Stylish\getStylish;
use function DiffCalc\Formatter\Stylish\getStylishDiffFormat;
use function DiffCalc\Formatter\Plain\getPlain;
use function DiffCalc\Formatter\Plain\getPlainDiffFormat;

function getFormatted(array $comparisonArray, string $format = 'stylish')
{
    if ($format === 'stylish') {
        $outputStylish = getStylish($comparisonArray);
        return getStylishDiffFormat($outputStylish);
    } elseif ($format === 'plain') {
        $outputPlain = getPlain($comparisonArray);
        return getPlainDiffFormat($outputPlain);
    }
}
