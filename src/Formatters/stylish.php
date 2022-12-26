<?php

namespace DiffCalc\Formatter\Stylish;

function getStylish(array $comparisonArray)
{
    //var_dump($item['children']);
    return array_map(function ($item) {
        //$key = $item['key'];
        $status = $item['status'];

        if (isset($item['value']) and is_array($item['value'])) {
            //$item['value'] = getStylish($item['value']);
            $item['value'] = implode("\n", $item['value']);
        }

        switch ($status) {
            case 'no change':
                return "{$item['key']}: {$item['value']}";
            case 'update':
                $first = "- {$item['key']}: {$item['value']}";
                $second = "+ {$item['key']}: {$item['oldValue']}";
                return "{$first}\n{$second}";
            case 'remove':
                return "- {$item['key']}: {$item['value']}";
            case 'add':
                return "+ {$item['key']}: {$item['value']}";
            case 'root':
                //$children = getStylish($item['children']);
                $strChildren = implode($item['children']);
                //print_r($strChildren);
                return "{$item['key']}: {$strChildren}";
        }

       //if ($status === 'no change') {
       //    $acc[$key] = $item['value'];
       //} elseif ($status === 'update') {
       //    $acc['- ' . $key] = $item['value'];
       //    $acc['+ ' . $key] = $item['oldValue'];
       //} elseif ($status === 'remove') {
       //    $acc['- ' . $key] = $item['value'];
       //} elseif ($status === 'add') {
       //    $acc['+ ' . $key] = $item['value'];
       //} elseif ($status === 'root') {
       //    $acc[$key] = getStylish($item['children']);
       //}

        
    }, $comparisonArray);
}


function getStylishDiffFormat(array $comparisonArray)
{
    //return $comparisonArray;
    $encodeContent = json_encode($comparisonArray, JSON_PRETTY_PRINT);
    $char = ['"', ','];
    $formattedContent = str_replace($char, '', $encodeContent);

    return str_replace("  - ", "- ", str_replace("  + ", "+ ", $formattedContent));
}
