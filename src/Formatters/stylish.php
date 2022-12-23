<?php

namespace DiffCalc\Formatter\Stylish;

use function Differ\Build\getValue;

function getStylish(array $comparisonArray)
{
    //var_dump($comparisonArray);
    $result = array_reduce($comparisonArray, function ($acc, $item) {
        $key = $item['key'];
        $value = isset($item['value']) ? $item['value'] : $item['children'];
        $status = $item['status'];

        if ($status != 'root') {
            $value = getValue($value);
        }

        if ($status === 'no change') {
            $acc[$key] = $value;
        } elseif ($status === 'update') {
            $acc['- ' . $key] = $value;
            $acc['+ ' . $key] = $item['oldValue'];
        } elseif ($status === 'remove') {
            $acc['- ' . $key] = $value;
        } elseif ($status === 'add') {
            $acc['+ ' . $key] = $value;
        } elseif ($status === 'root') {
            $acc[$key] = getStylish($item['children']);
        }

        return $acc;
    }, []);

    return $result;
}


function getStylishDiffFormat(array $comparisonArray)
{
    //return $comparisonArray;
    $encodeContent = json_encode($comparisonArray, JSON_PRETTY_PRINT);
    $char = ['"', ','];
    $formattedContent = str_replace($char, '', $encodeContent);

    return str_replace("  - ", "- ", str_replace("  + ", "+ ", $formattedContent));
}
