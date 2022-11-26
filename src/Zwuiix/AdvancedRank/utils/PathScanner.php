<?php

namespace Zwuiix\AdvancedRank\utils;

use Generator;
use JsonException;
use Webmozart\PathUtil\Path;
use Zwuiix\AdvancedRank\config\Config;

class PathScanner
{
    public static function scanDirectory(string $path, array $filterExtension = []): array
    {
        $scanDir = [];
        foreach (scandir($path,0) as $file) {
            if ($file === ".." || $file === '.') continue;
            if (is_dir($realpath = Path::join($path, $file))) {
                $scanDir = array_merge(self::scanSubDirectory($path, $file, $filterExtension), $scanDir);
                continue;
            }
            if (!empty($filterExtension) && !in_array(pathinfo($realpath)["extension"] ?? "NULL", $filterExtension)) continue;
            if (!is_file($realpath)) continue;
            $scanDir[] = $realpath;
        }
        return $scanDir;
    }

    /**
     * @throws JsonException
     */
    public static function scanDirectoryToConfig(string $path, array $filterExtension = [], int $typeConfig = Config::YAML): ?Generator
    {
        foreach (self::scanDirectory($path, $filterExtension) as $file){
            yield $file => new Config($file, $typeConfig);
        }
        return null;
    }

    private static function scanSubDirectory(string $path, string $nextPath, array $filterExtension = []): array{
        $scanDir = [];
        foreach (scandir($pathJoin = Path::join($path,$nextPath),0) as $file){
            if ($file === ".." || $file === '.') continue;
            if (is_dir($realpath = Path::join($pathJoin, $file))) {
                $scanDir = array_merge(self::scanSubDirectory($pathJoin, $file, $filterExtension), $scanDir);
                continue;
            }
            if (!empty($filterExtension) && !in_array(pathinfo($realpath)["extension"] ?? "NULL", $filterExtension)) continue;
            if (!is_file($realpath)) continue;
            $scanDir[] = $realpath;
        }
        return  $scanDir;
    }
}