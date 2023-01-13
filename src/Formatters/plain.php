<?php

namespace DiffCalc\Formatter\Plain;

use function Functional\flatten;

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
}

function getPlainDiffFormat(array $array)
{
    $encode = implode("\n", $array);
    return $encode;
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
    } elseif (is_array($value)) {
        return "[complex value]";
    }
    return $value;
}
