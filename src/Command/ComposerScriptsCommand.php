<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ComposerScriptsCommand extends Command
{
    /**
     * @var array<string, string>
     */
    private const COMPOSER_SCRIPTS = [
        'phpstan' => 'vendor/bin/phpstan',
        'check-cs' => 'vendor/bin/ecs',
        'fix-cs' => 'vendor/bin/ecs --fix',
    ];

    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('composer-scripts');
        $this->setDescription('Add shortcut to composre scripts');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->symfonyStyle->title('Adding composer scripts for coding standard and PHPStan...');

        // modify composer json
        $composerJson = $this->loadComposerJson();
        $composerJson['scripts'] = array_merge($composerJson['scripts'] ?? [], self::COMPOSER_SCRIPTS);

        $this->writeComposerJson($composerJson);

        $this->symfonyStyle->success('Done');

        return self::SUCCESS;
    }

    /**
     * @return array<string, mixed>
     */
    private function loadComposerJson(): array
    {
        $composerJsonContents = FileSystem::read(getcwd() . '/composer.json');

        return Json::decode($composerJsonContents, Json::FORCE_ARRAY);
    }

    /**
     * @param array<string, mixed> $composerJson
     */
    private function writeComposerJson(array $composerJson): void
    {
        $composerJsonContents = Json::encode($composerJson, Json::PRETTY) . PHP_EOL;

        FileSystem::write(getcwd() . '/composer.json', $composerJsonContents);
    }
}
