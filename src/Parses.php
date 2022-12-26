<?php

namespace DiffCalc\Parses;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;

function pathToArray(string $path)
{
    $format = Yaml::parse($path, Yaml::PARSE_OBJECT_FOR_MAP);
    $formatFile = pathinfo($format, PATHINFO_EXTENSION);
    if ($formatFile === 'json') {
        return json_decode(file_get_contents($path), true);
    } elseif ($formatFile === 'yml' or $formatFile === 'yaml') {
        return Yaml::parseFile($path);
    }
}
