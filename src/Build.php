<?php

namespace Differ\Build;

function getBuildDiff (array $contentFromFirstFile, array $contentFromSecondFile) {

    $merge = array_merge($contentFromFirstFile, $contentFromSecondFile);
    $keys = array_keys($merge);

    $r = array_reduce($keys, function ($acc, $key) use ($contentFromFirstFile, $contentFromSecondFile) {
        if (key_exists($key, $contentFromFirstFile) and key_exists($key, $contentFromSecondFile)) {
            if ($contentFromFirstFile[$key] === $contentFromSecondFile[$key]) {
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
        return $acc;
    }, []);

    return $r;

// $result = [];
//
// $uniqueValuesFromFirstFile = array_diff_key($contentFromFirstFile, $contentFromSecondFile); // with -
// $uniqueValuesFromSecondFile = array_diff_key($contentFromSecondFile, $contentFromFirstFile); // with +
// $intersect = array_intersect_assoc($contentFromFirstFile, $contentFromSecondFile); // nothin 
// foreach ($contentFromFirstFile as $key => $value){
//     if (is_array($value)) {
//         getBuildDiff($value, $contentFromSecondFile[$key]);
//     }
//     if (array_key_exists($key, $uniqueValuesFromFirstFile)) {
//         $result[] = "- {$key}: {$value}";
//     } elseif (array_key_exists($key, $intersect)) {
//         $result[] = "  {$key}: {$value}";
//     } elseif ($contentFromFirstFile[$key] != $contentFromSecondFile[$key]) {
//         $result[] = "- {$key}: {$value}";
//         $result[] = "+ {$key}: {$contentFromSecondFile[$key]}";
//     }
// }
// foreach ($uniqueValuesFromSecondFile as $key => $value) {
//     $result[] = "+ {$key}: {$value}";
// }
// $resultStr = trim(json_encode($result, JSON_PRETTY_PRINT), '[]');
// $resultStr = str_replace('"', '', $jsonStr);
// return '{' . $resultStr . '}';
}