<?php

namespace DiffCalc\Differ;

use function Functional\flatten;

function getContentFileFromPath(string $path)
{
    $contentFromFile = trim(file_get_contents($path), '{}');

    $contentFromFile = explode(',', $contentFromFile);

    $contentFromFile = array_reduce($contentFromFile, function ($acc, $item) {
        $strtoArray = explode(':', $item);
        $acc[] = [trim($strtoArray[0]) => trim($strtoArray[1])];
        return $acc;
    }, []);

    $result = [];
    for($i = 0; $i < count($contentFromFile); $i++) {
        $keyFromArray = key($contentFromFile[$i]);
        $valueFromArray = $contentFromFile[$i][$keyFromArray];

        $keyFromArray = trim($keyFromArray, '"');
        $valueFromArray = trim($valueFromArray, '"');

        $result[$keyFromArray] = $valueFromArray;
    }

    return $result;
}

function getDiffCalc(string $formatOutput, string $firstPath, string $secondPath)
{
    $contentFromFirstFile = getContentFileFromPath($firstPath);
    ksort($contentFromFirstFile);
    $contentFromSecondFile = getContentFileFromPath($secondPath);

    $result = [];

    foreach ($contentFromFirstFile as $key => $value) {
        if (!array_key_exists($key, $contentFromSecondFile)) {
            $result[] = "- {$key}: {$value}";
        } elseif ($contentFromFirstFile[$key] === $contentFromSecondFile[$key]) {
            $result[] = "  {$key}: {$value}";
        } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
            $result[] = "- {$key}: {$value}";
            $result[] = "+ {$key}: {$contentFromSecondFile[$key]}";
        }
    }
    
    if (array_diff_key($contentFromFirstFile, $contentFromSecondFile)) {
        $diff = array_diff_key($contentFromSecondFile, $contentFromFirstFile);
        foreach ($diff as $key => $value) {
            $result[] = "+ {$key}: {$value}";
        }
    }
    
    $diffFilesToStr = implode("\n", $result);
    
    return "{\n" . "{$diffFilesToStr}" . "\n}\n";
}

