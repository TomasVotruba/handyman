<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\FileSystem;

use Nette\Utils\FileSystem;
use Webmozart\Assert\Assert;

final class TemplateFileSystem
{
    /**
     * @param array<string, string|float|int|null> $variables
     */
    public static function renderFilePathWithVariables(
        string $sourceFilePath,
        array $variables,
        ?string $targetFilePath = null
    ): string {
        Assert::fileExists($sourceFilePath);

        $templateContents = FileSystem::read($sourceFilePath);
        $fileContents = str_replace(array_keys($variables), array_values($variables), $templateContents);

        // save file contents directly
        if (is_string($targetFilePath)) {
            FileSystem::write($targetFilePath, $fileContents);
        }

        return $fileContents;
    }
}
