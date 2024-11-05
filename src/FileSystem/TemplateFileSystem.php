<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\FileSystem;

use Nette\Utils\FileSystem;

final class TemplateFileSystem
{
    /**
     * @param array<string, string|float|int|null> $variables
     */
    public static function renderFilePathWithVariables(string $sourceFilePath, array $variables): string
    {
        $fileContents = FileSystem::read($sourceFilePath);
        return str_replace(array_keys($variables), array_values($variables), $fileContents);
    }
}
