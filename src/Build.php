<?php

namespace Differ\Build;

function getBuildDiff(array $contentFromFirstFile, array $contentFromSecondFile)
{
    $merge = array_merge($contentFromFirstFile, $contentFromSecondFile);
    ksort($merge);
    $keys = array_keys($merge);

    $result = array_reduce($keys, function ($acc, $key) use ($contentFromFirstFile, $contentFromSecondFile) {
        if (key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            if (is_array($contentFromFirstFile[$key]) and is_array($contentFromSecondFile[$key])) {
                $acc[] = ['key' => $key,
                'status' => 'array',
                'value' => getBuildDiff($contentFromFirstFile[$key], $contentFromSecondFile[$key])];
            } elseif ($contentFromFirstFile[$key] === $contentFromSecondFile[$key]) {
                $acc[] = ['key' => $key,
                'status' => 'no change',
                'value' => $contentFromFirstFile[$key]];
            } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
                $acc[] = ['key' => $key,
                'status' => 'update',
                'value' => $contentFromFirstFile[$key],
                'oldValue' => $contentFromSecondFile[$key]];
            }
        } elseif (key_exists($key, $contentFromFirstFile) and !key_exists($key, $contentFromSecondFile)) {
            $acc[] = ['key' => $key,
            'status' => 'remove',
            'value' => $contentFromFirstFile[$key]];
        } elseif (!key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            $acc[] = ['key' => $key,
            'status' => 'add',
            'value' => $contentFromSecondFile[$key]];
        }

        return $acc;
    }, []);


    return $result;
}

function getValue($value)
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    }
    return $value;
}
