<?php

namespace DiffCalc\Parses;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;

function pathToArray(string $path)
{
    $format = Yaml::parse($path, Yaml::PARSE_OBJECT_FOR_MAP);
    $format = pathinfo($format, PATHINFO_EXTENSION);
    if ($format === 'json') {
        $contentFromFile = json_decode(file_get_contents($path), true);
    } elseif ($format === 'yml' or $format === 'yaml') {
        $contentFromFile = Yaml::parseFile($path);
    }
    return $contentFromFile;
}
