<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Finder;

use Nette\Utils\Strings;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;

final class ClassFinder
{
    /**
     * @return string[]
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

        Assert::allString($classNames);
        Assert::allClassExists($classNames);

        // remove abstract classes, check via reflection
        return array_filter($classNames, fn (string $className) => ! (new \ReflectionClass($className))->isAbstract());
    }

    private static function createClassNameFromFilePath(string $realPath): string
    {
        // use path part after "src"
        $nestedClassName = str_replace('/', '\\', (string) Strings::after($realPath, 'src'));

        // remove. php suffix
        $nestedClassName = substr($nestedClassName, 0, -4);

        // add namespace root
        return 'TomasVotruba\\Handyman' . $nestedClassName;
    }
}
