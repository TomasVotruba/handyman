<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\ValueObject;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Nette\Utils\Strings;
use Webmozart\Assert\Assert;

final class ComposerJson
{
    private string $composerJsonFilePath;

    /**
     * @var array<string, mixed>
     */
    private array $json = [];

    public function __construct(string $composerJsonFilePath)
    {
        Assert::fileExists($composerJsonFilePath);
        $this->composerJsonFilePath = $composerJsonFilePath;

        $this->json = Json::decode(FileSystem::read($this->composerJsonFilePath), true);
    }

    public function getPhpVersionString(): string
    {
        $requirePhp = $this->json['require']['php'] ?? null;
        Assert::string($requirePhp);

        $match = Strings::match($requirePhp, '#(?<version>\d\.\d)#');
        Assert::isArray($match);
        Assert::keyExists($match, 'version');

        return $match['version'];
    }
}
