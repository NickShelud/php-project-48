<?php

namespace DiffCalc\Formatter\Json;

function getJson(array $comparisonArray)
{
    return json_encode($comparisonArray, JSON_PRETTY_PRINT);
}
