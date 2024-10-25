<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\FileSystem;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;

final class JsonFileSystem
{
    public static function read(string $filePath, string $key)
    {
        $fileContents = FileSystem::read($filePath);
        $json = Json::decode($fileContents, forceArrays: true);

        return $json[$key] ?? null;
    }
}