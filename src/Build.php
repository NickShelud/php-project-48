<?php

namespace Differ\Build;

function getBuildDiff (array $contentFromFirstFile, array $contentFromSecondFile) {

    $merge = array_merge($contentFromFirstFile, $contentFromSecondFile);
    $keys = array_keys($merge);

    $result = array_reduce($keys, function ($acc, $key) use ($contentFromFirstFile, $contentFromSecondFile) {

        if (key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            if (is_array($contentFromFirstFile[$key]) and is_array($contentFromSecondFile[$key])) {
                return getBuildDiff($contentFromFirstFile[$key], $contentFromSecondFile[$key]);
            } elseif ($contentFromFirstFile[$key] === $contentFromSecondFile[$key]) {
                $acc['  ' . $key] = $contentFromFirstFile[$key];
            } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
                $acc['- ' . $key] = $contentFromFirstFile[$key];
                $acc['+ ' . $key] = $contentFromSecondFile[$key];
            }
        } elseif (key_exists($key, $contentFromFirstFile) and !key_exists($key, $contentFromSecondFile)) {
            $acc['- ' . $key] = $contentFromFirstFile[$key];
        } elseif (!key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            $acc['+ ' . $key] = $contentFromSecondFile[$key];
        }
        //$newAcc[] = $acc;
        return $acc;
    }, []);

    return $result;
}