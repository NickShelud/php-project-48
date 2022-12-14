<?php

namespace DiffCalc\Formatter\Plain;

use function Functional\flatten;
use function Differ\Build\getValue;

function getPlain(array $comparisonArray, string $oldKey = '')
{

    return flatten(array_map(function ($item) use ($oldKey) {
        $status = $item['status'];

        if ($oldKey != '') {
            $key = "{$oldKey}.{$item['key']}";
        } else {
            $key = $item['key'];
        }

        switch ($status) {
            case 'add':
                $value = getValue($item['value']);
                return "Property '{$key}' was added with value: {$value}";
            case 'remove':
                return "Property '{$key}' was removed";
            case 'update':
                $value = getValue($item['value']);
                $oldValue = getValue($item['oldValue']);
                return "Property '{$key}' was updated. From {$value} to {$oldValue}";
            case 'root':
                return getPlain($item['children'], $key);
            case 'no change':
                return [];
        }
    }, $comparisonArray));

    //return flatten($result);
}

function getPlainDiffFormat(array $array)
{
    $encode = implode("\n", $array);
    return $encode;
}
