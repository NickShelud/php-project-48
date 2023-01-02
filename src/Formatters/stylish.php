<?php

namespace DiffCalc\Formatter\Stylish;

use function Differ\Build\getValue;

function getStylish(array $comparisonArray, int $depth = 1)
{

    return array_map(function ($item) use ($depth) {
        $key = $item['key'] ?? null;
        $status = $item['status'] ?? null;

        $indent = getIndent($depth);
        $smallIndent = getSmallIndent($depth);

        if ($status === 'no change') {
            $value = getArrayToStr($item['value'], $depth);
            return "{$indent}{$key}: {$value}";
        } elseif ($status === 'update') {
            $value = getArrayToStr($item['value'], $depth);
            $oldValue = getArrayToStr($item['oldValue'], $depth);

            if (is_array($item['value'])) {
                return "{$smallIndent}- {$key}: {{$value}\n$smallIndent  }\n$smallIndent+ {$key}: {$oldValue}";
            } elseif (is_array($item['oldValue'])) {
                return "{$smallIndent}- {$key}: {$value}\n$smallIndent+ {$key}: {{$oldValue}\n{$smallIndent}  }";
            }

            return "{$smallIndent}- {$key}: {$value}\n$smallIndent+ {$key}: {$oldValue}";
        } elseif ($status === 'remove') {
            $value = getArrayToStr($item['value'], $depth);

            if (is_array($item['value'])) {
                return "{$smallIndent}- {$key}: {{$value}\n  {$smallIndent}}";
            }
            return "{$smallIndent}- {$key}: {$value}";
        } elseif ($status === 'add') {
            $value = getArrayToStr($item['value'], $depth);
            if (is_array($item['value'])) {
                return "{$smallIndent}+ $key: {" . "$value\n  {$smallIndent}}";
            }
            return "{$smallIndent}+ $key: {$value}";
        } elseif ($status === 'root') {
            $children = implode("\n", getStylish($item['children'], $depth + 1));
            return "{$indent}{$key}: {\n" . $children . "\n{$indent}}";
        }
    }, $comparisonArray);
}


function getStylishDiffFormat(array $comparisonArray)
{
    $result = implode("\n", $comparisonArray);
    return "{\n" . $result . "\n}";
}

function getString(mixed $value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_null($value)) {
        return 'null';
    } elseif (is_string($value)) {
        return $value;
    } elseif (is_int($value)) {
        return "{$value}";
    }
}

function getIndent(int $depth = 1, int $depthForSmallIndent = 0)
{
    $indent = 4;

    return str_repeat(' ', $indent * $depth - $depthForSmallIndent);
}

function getSmallIndent(int $depth)
{
    return getIndent($depth, 2);
}

function getArrayToStr(mixed $value, int $depth): string
{
    if (!is_array($value)) {
        return getString($value);
    }
    $keys = array_keys($value);
    $result = array_map(function ($item, $key) use ($depth) {
        $indent = getIndent($depth + 1);
        if (is_array($item)) {
            return "\n{$indent}{$key}: {" . getArrayToStr($item, $depth + 1) . "\n{$indent}}";
        } else {
            return "\n{$indent}$key: $item";
        }

        //print_r($result);
    }, $value, $keys);
    return str_replace("\n\n", "\n", implode("\n", $result));
}
