<?php

namespace DiffCalc\Formatter\Plain;

use function Functional\flatten;

function getPlain(array $comparisonArray, string $oldKey = '')
{
    $result = array_reduce($comparisonArray, function ($acc, $item) use ($oldKey){
        $status = $item['status'];
        $key = $item['key'];

        if (isset($oldKey) and $oldKey != '') {
            $key = "{$oldKey}.{$key}";
        }

        $value = $item['value'];
        if (is_array($value) and $status != 'array') {
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
                $acc[] = "Property '{$key}' was updated. From {$item['oldValue']} to {$value}";
                break;
            case 'array':
                $acc[] = getPlain($value, $key);
        }

        return $acc;
    }, []);

    return flatten($result);
}

function getPlainDiffFormat(array $array)
{
    $encode = json_encode($array, JSON_PRETTY_PRINT, JSON_PRESERVE_ZERO_FRACTION);
    $char = ['"', ',', '[', ']'];
    return '    ' . ltrim(str_replace($char, '', $encode));
}
