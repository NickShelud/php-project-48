<?php

namespace DiffCalc\Parses;

use Symfony\Component\Yaml\Yaml;

function pathToArray(string $path, string $format)
{
    if ($format === 'json') {
        $file = file_get_contents($path);
        return json_decode($file, true);
    } elseif ($format === 'yml' or $format === 'yaml') {
        return Yaml::parseFile($path);
    }
}
