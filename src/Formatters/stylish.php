<?php

namespace DiffCalc\Formatter\Stylish;

function getStylish(array $comparisonArray)
{
    //var_dump($comparisonArray);
    $result = array_reduce($comparisonArray, function ($acc, $item) {
        $key = $item['key'];
        $status = $item['status'];

        if ($status === 'no change') {
            $acc[$key] = $item['value'];
        } elseif ($status === 'update') {
            $acc['- ' . $key] = $item['value'];
            $acc['+ ' . $key] = $item['oldValue'];
        } elseif ($status === 'remove') {
            $acc['- ' . $key] = $item['value'];
        } elseif ($status === 'add') {
            $acc['+ ' . $key] = $item['value'];
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
