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

        if (isset($item['value'])) {
            if (is_array($item['value']) and $status != 'root') {
                $item['value'] = "[complex value]";
            } else {
                $item['value'] = gettype($item['value']) != 'string' ?  getValue($item['value']) : "'{$item['value']}'";
            }
        }

        switch ($status) {
            case 'add':
                $acc[] = "Property '{$key}' was added with value: {$item['value']}";
                break;
            case 'remove':
                $acc[] = "Property '{$key}' was removed";
                break;
            case 'update':
                $item['oldValue'] = $item['oldValue'] ? "'{$item['oldValue']}'" : 'null';
                $acc[] = "Property '{$key}' was updated. From {$item['value']} to {$item['oldValue']}";
                break;
            case 'root':
                $acc[] = getPlain($item['children'], $key);
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
