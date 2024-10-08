<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Finder;

use Symfony\Component\Finder\Finder;

final class ClassFinder
{
    /**
     * @return array<class-string>
     */
    public static function find(string $directory): array
    {
        // load commands from src/Command
        $commandsFinder = Finder::create()
            ->files()
            ->in($directory)
            ->sortByName();

        $classNames = [];

        foreach ($commandsFinder->getIterator() as $commandFileInfo) {
            $classNames[] = self::createClassNameFromFilePath($commandFileInfo->getRealPath());
        }

        // remove abstract classes, check via reflection
        return array_filter($classNames, fn (string $className) => ! (new \ReflectionClass($className))->isAbstract());
    }

    private static function createClassNameFromFilePath(string $realPath): string
    {
        // use path part after "src"
        $nestedClassName = str_replace('/', '\\', \Nette\Utils\Strings::after($realPath, 'src'));

        // remove. php suffix
        $nestedClassName = substr($nestedClassName, 0, -4);

        // add namespace root
        return 'TomasVotruba\\Handyman' . $nestedClassName;
    }
}