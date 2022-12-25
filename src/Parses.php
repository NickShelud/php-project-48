<?php

namespace DiffCalc\Parses;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser;

function pathToArray(string $contentFile, string $path)
{
    $format = Yaml::parse($path, Yaml::PARSE_OBJECT_FOR_MAP);
    $formatFile = pathinfo($format, PATHINFO_EXTENSION);
    if ($formatFile === 'json') {
        return json_decode($contentFile, true, JSON_THROW_ON_ERROR);
    } elseif ($formatFile === 'yml' or $formatFile === 'yaml') {
        return Yaml::parseFile($path);
    }
}
