<?php

namespace DiffCalc\Formatter\Stylish;

use function Differ\Build\getValue;

function getStylish(array $comparisonArray)
{
    //var_dump($item['children']);
    return array_reduce($comparisonArray, function ($acc, $item) {
        $key = $item['key'];
        $status = $item['status'];
        $depth = '  ';

       //if (isset($item['value']) and is_array($item['value'])) {
       //    $newDepth = str_repeat($depth, 4);
       //    $item['value'] = getStr($item['value'], $newDepth);
       //} elseif (isset($item['children'])) {
       //    $children = getStylish($item['children']);
       //    $childrenStr = implode("\n", $children);
       //} else {
       //    $item['value'] = getValue($item['value']);
       //}

       //if ($status === 'no change') {
       //    $newDepth = str_repeat($depth, 4);
       //    return "$newDepth{$key}: {$item['value']}";
       //} elseif ($status === 'update') {
       //    $newDepth = str_repeat($depth, 3);
       //    return "$newDepth- {$key}: {$item['value']}\n$newDepth+ {$key}: {$item['value']}";
       //} elseif ($status === 'remove') {
       //    $newDepth = str_repeat($depth, 3);
       //    return "$newDepth- {$key}: {$item['value']}";
       //} elseif ($status === 'add') {
       //    $newDepth = str_repeat($depth, 3);
       //    return "$newDepth+ {$key}: {$item['value']}";
       //} elseif ($status === 'root') {
       //    $newDepth = str_repeat($depth, 2);
       //    return "{$key}:\n {$childrenStr}";
       //}


        if ($status === 'no change') {
            $acc[$key] = $item['value'];
            return $acc;
        } elseif ($status === 'update') {
            $acc['- ' . $key] = $item['value'];
            $acc['+ ' . $key] = $item['oldValue'];
            return $acc;
        } elseif ($status === 'remove') {
            $acc['- ' . $key] = $item['value'];
            return $acc;
        } elseif ($status === 'add') {
            $acc['+ ' . $key] = $item['value'];
            return $acc;
        } elseif ($status === 'root') {
            $acc[$key] = getStylish($item['children']);
            return $acc;
        }
    }, []);

    return $result;
}


function getStylishDiffFormat(array $comparisonArray)
{
    //print_r($comparisonArray);
    //return $comparisonArray;
    //$result = implode("\n", $comparisonArray);
    //return $result;
    $encodeContent = json_encode($comparisonArray, JSON_PRETTY_PRINT);
    $char = ['"', ','];
    $formattedContent = str_replace($char, '', $encodeContent);

    return str_replace("  - ", "- ", str_replace("  + ", "+ ", $formattedContent));
}

function getStr($arr, $depth)
{
    $str = json_encode($arr, JSON_PRETTY_PRINT);
    //print_r($str);
    $str = ' ' . $str;
    $char = ['"', ',', " {\n"];
    return "{\n" . $depth . str_replace($char, '', $str);
}
