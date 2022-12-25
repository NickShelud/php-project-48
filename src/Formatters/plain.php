<?php

namespace DiffCalc\Formatter\Plain;

use function Functional\flatten;
use function Differ\Build\getValue;

function getPlain(array $comparisonArray, string $oldKey = '')
{

    return flatten(array_map(function ($item) use ($oldKey) {
        $status = $item['status'];

        if (isset($oldKey) and $oldKey != '') {
            $key = "{$oldKey}.{$item['key']}";
        } else {
            $key = $item['key'];
        }

        switch ($status) {
            case 'add':
                $value = getValue($item['value']);
                return "Property '{$key}' was added with value: {$value}";
                break;
            case 'remove':
                return "Property '{$key}' was removed";
                break;
            case 'update':
                $value = getValue($item['value']);
                $oldValue = getValue($item['oldValue']);
                return "Property '{$key}' was updated. From {$value} to {$oldValue}";
                break;
            case 'root':
                return getPlain($item['children'], $key);
                break;
            case 'no change':
                return [];
        }
    }, $comparisonArray));

    //return flatten($result);
}

function getPlainDiffFormat(array $array)
{
    $encode = json_encode($array, JSON_PRETTY_PRINT);
    $char = ['"', ',', '    '];
    $trim = trim(str_replace($char, '', $encode), '[]');

    return trim($trim);
}
