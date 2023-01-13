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
            $operator = ' ';

            return getStylishFormat($item['value'], $key, $smallIndent, $operator, $depth);
        } elseif ($status === 'update') {
            $newValue = getStylishFormat($item['value'], $key, $smallIndent, '-', $depth);
            $oldValue = getStylishFormat($item['oldValue'], $key, $smallIndent, '+', $depth);

            return $newValue . "\n" . $oldValue;
        } elseif ($status === 'remove') {
            $operator = '-';

            return getStylishFormat($item['value'], $key, $smallIndent, $operator, $depth);
        } elseif ($status === 'add') {
            $operator = '+';

            return getStylishFormat($item['value'], $key, $smallIndent, $operator, $depth);
        } elseif ($status === 'root') {
            $children = implode("\n", getStylish($item['children'], $depth + 1));
            return "{$indent}{$key}: {\n" . $children . "\n{$indent}}";
        }
    }, $comparisonArray);
}

function getStylishFormat(mixed $value, mixed $key, string $smallIndent, string $operator, int $depth)
{
    $newValue = getArrayToStr($value, $depth);
    if (is_array($value)) {
        return "{$smallIndent}{$operator} $key: {" . "$newValue\n  {$smallIndent}}";
    }
    return "{$smallIndent}{$operator} $key: {$newValue}";
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
    }, $value, $keys);
    return str_replace("\n\n", "\n", implode("\n", $result));
}
