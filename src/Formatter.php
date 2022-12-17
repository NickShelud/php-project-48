<?php

namespace DiffCalc\Formatter;

use function DiffCalc\Formatter\Stylish\getStylish;

function getFormatted(array $comparisonArray, string $format = 'stylish') {
    if ($format === 'stylish') {
        return getStylish($comparisonArray);
    }
}