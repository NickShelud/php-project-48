<?php

namespace DiffCalc\Formatter;

use function DiffCalc\Formatter\Stylish\getStylish;
use function DiffCalc\Formatter\Stylish\getStylishDiffFormat;
use function DiffCalc\Formatter\Plain\getPlain;
use function DiffCalc\Formatter\Plain\getPlainDiffFormat;
use function DiffCalc\Formatter\Json\getJson;

function getFormatted(array $comparisonArray, string $format = 'stylish')
{
    switch ($format) {
        case 'stylish':
            $outputStylish = getStylish($comparisonArray);
            return getStylishDiffFormat($outputStylish);
        case 'plain':
            $outputPlain = getPlain($comparisonArray);
            return getPlainDiffFormat($outputPlain);
        case 'json':
            return getJson($comparisonArray);
    }
}
