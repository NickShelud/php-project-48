<?php

namespace DiffCalc\Formatter;

use function Functional\flatten;

function arrayToString(string $sign, array $array)
{
    $key = key($array);
    $value = $array[$key];

    return "{$sign} {$key}: {$value}";
}

function getFormatted(array $comparisonArray) {
    $encodeContent = json_encode($comparisonArray, JSON_PRETTY_PRINT);
    $char = ['"', ','];
    $formattedContent = str_replace($char, '', $encodeContent);
    return $formattedContent;
}