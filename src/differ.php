<?php

namespace DiffCalc\Differ;

use function Functional\flatten;

function getDiffCalc(string $formatOutput, string $firstPath, string $secondPath)
{
    $contentFromFirstFile = json_decode(file_get_contents($firstPath), true);
    ksort($contentFromFirstFile);
    $contentFromSecondFile = json_decode(file_get_contents($secondPath), true);

    $result = [];

    $uniqueValuesFromFirstFile = array_diff_key($contentFromFirstFile, $contentFromSecondFile); // with -
    $uniqueValuesFromSecondFile = array_diff_key($contentFromSecondFile, $contentFromFirstFile); // with +
    $intersect = array_intersect_assoc($contentFromFirstFile, $contentFromSecondFile); // nothing

    foreach ($contentFromFirstFile as $key => $value) {
        if (array_key_exists($key, $uniqueValuesFromFirstFile)) {
            $result[] = "- {$key}: {$value}";
        } elseif (array_key_exists($key, $intersect)) {
            $result[] = "  {$key}: {$value}";
        } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
            $result[] = "- {$key}: {$value}";
            $result[] = "+ {$key}: {$contentFromSecondFile[$key]}";
        }
    }

    foreach ($uniqueValuesFromSecondFile as $key => $value) {
        $result[] = "+ {$key}: {$value}";
    }

    $jsonStr = trim(json_encode($result, JSON_PRETTY_PRINT), '[]');
    $jsonStr = str_replace('"', '', $jsonStr);
    return '{' . $jsonStr . '}';
}
