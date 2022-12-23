<?php

namespace DiffCalc\Formatter\Plain;

use function Functional\flatten;
use function Differ\Build\getValue;

function getPlain(array $comparisonArray, string $oldKey = '')
{
    $result = array_reduce($comparisonArray, function ($acc, $item) use ($oldKey) {
        $status = $item['status'];
        $key = $item['key'];

        if (isset($oldKey) and $oldKey != '') {
            $key = "{$oldKey}.{$key}";
        }

        $value = isset($item['value']) ? $item['value'] : $item['children'];

        $value = gettype($value) != 'string' ?  getValue($value) : "'{$value}'";

        if (is_array($value) and $status != 'root') {
            $value = "[complex value]";
        }

        switch ($status) {
            case 'add':
                $acc[] = "Property '{$key}' was added with value: {$value}";
                break;
            case 'remove':
                $acc[] = "Property '{$key}' was removed";
                break;
            case 'update':
                $item['oldValue'] = $item['oldValue'] ? "'{$item['oldValue']}'" : 'null';
                $acc[] = "Property '{$key}' was updated. From {$value} to {$item['oldValue']}";
                break;
            case 'root':
                $acc[] = getPlain($value, $key);
        }

        return $acc;
    }, []);

    return flatten($result);
}

function getPlainDiffFormat(array $array)
{
    $encode = json_encode($array, JSON_PRETTY_PRINT, JSON_PRESERVE_ZERO_FRACTION);
    $char = ['"', ',', '    '];
    $trim = trim(str_replace($char, '', $encode), '[]');

    return ltrim($trim);
}
