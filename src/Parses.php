<?php

namespace DiffCalc\Parses;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;

function pathToArray(string $path)
{
    $format = Yaml::parse($path, Yaml::PARSE_OBJECT_FOR_MAP);
    $formatFile = pathinfo($format, PATHINFO_EXTENSION);
    if ($formatFile === 'json') {
        $contentFile = file_get_contents($path);
        return json_decode($contentFile, true);
    } elseif ($formatFile === 'yml' or $formatFile === 'yaml') {
        return Yaml::parseFile($path);
    }
}
