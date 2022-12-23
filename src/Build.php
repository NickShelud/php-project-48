<?php

namespace Differ\Build;

function getBuildDiff(array $contentFromFirstFile, array $contentFromSecondFile)
{
    $merge = ksort(array_merge($contentFromFirstFile, $contentFromSecondFile));
    $keys = array_keys($merge);

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

function getValue(mixed $value)
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    } elseif (gettype($value) === 'string') {
        return "'{$value}'";
    }
    return $value;
}
