<?php

namespace Differ\Differ;

use function Functional\flatten;
use function DiffCalc\Parses\pathToArray;
use function DiffCalc\Formatter\getFormatted;
use function Functional\sort;

function genDiff(string $firstPath, string $secondPath, string $formatOutput = 'stylish')
{
    $contentFromFirstFile = pathToArray($firstPath);
    $contentFromSecondFile = pathToArray($secondPath);

    $buildDiff = getBuildDiff($contentFromFirstFile, $contentFromSecondFile);

    return getFormatted($buildDiff, $formatOutput);
}

function getBuildDiff(array $contentFromFirstFile, array $contentFromSecondFile)
{
    $merge = array_merge($contentFromFirstFile, $contentFromSecondFile);
    $mergeKeys = array_keys($merge);
    $keys = sort($mergeKeys, fn ($a, $b) => strcmp($a, $b));

    return array_map(function ($key) use ($contentFromFirstFile, $contentFromSecondFile) {
        if (key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            if (is_array($contentFromFirstFile[$key]) and is_array($contentFromSecondFile[$key])) {
                return ['key' => $key,
                'status' => 'root',
                'children' => getBuildDiff($contentFromFirstFile[$key], $contentFromSecondFile[$key])];
            } elseif ($contentFromFirstFile[$key] === $contentFromSecondFile[$key]) {
                return ['key' => $key,
                'status' => 'no change',
                'value' => $contentFromFirstFile[$key]];
            } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
                return ['key' => $key,
                'status' => 'update',
                'value' => $contentFromFirstFile[$key],
                'oldValue' => $contentFromSecondFile[$key]];
            } elseif (gettype($contentFromFirstFile[$key]) != gettype($contentFromSecondFile[$key])) {
                return ['key' => $key,
                'status' => 'update',
                'value' => $contentFromFirstFile[$key],
                'oldValue' => $contentFromSecondFile[$key]];
            }
        } elseif (key_exists($key, $contentFromFirstFile) and !key_exists($key, $contentFromSecondFile)) {
            return ['key' => $key,
            'status' => 'remove',
            'value' => $contentFromFirstFile[$key]];
        } elseif (!key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            return ['key' => $key,
            'status' => 'add',
            'value' => $contentFromSecondFile[$key]];
        }
    }, $keys);
}
