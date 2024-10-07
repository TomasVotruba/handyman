<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;

final class ProjectComposerAnalyser
{
    /**
     * @var array<string, mixed>
     */
    private array $composerJson;

    public function __construct()
    {
        // @todo maybe lazy load?

        $composerJsonContents = FileSystem::read(getcwd() . '/composer.json');
        $this->composerJson = Json::decode($composerJsonContents, forceArrays: true);
    }

    public function hasPackage(string $package): bool
    {
        return isset($this->composerJson['require'][$package]) || isset($this->composerJson['require-dev'][$package]);
    }

    /**
     * @return string[]
     */
    public function getDevPackages(): array
    {
        return array_keys($this->composerJson['require-dev'] ?? []);
    }
}
