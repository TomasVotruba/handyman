<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\FileSystem\JsonFileSystem;

final class ReadmeCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('readme');
        $this->setDescription('Add README.md and LICENSE files to the root with typical setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (file_exists(getcwd() . '/README.md') && file_exists(getcwd() . '/LICENSE')) {
            $this->symfonyStyle->warning('"README.md" already exists');
            return self::SUCCESS;
        }

        $readmeTemplateContents = FileSystem::read(__DIR__ . '/../../templates/README.md');
        $composerPackageName = JsonFileSystem::readString(getcwd() . '/composer.json', 'name');

        if (is_string($composerPackageName)) {
            // 1. install via composer, dev most likely
            $readmeTemplateContents = str_replace(
                '__COMPOSER_PACKAGE_NAME__',
                $composerPackageName,
                $readmeTemplateContents
            );
        }

        // 2. what it does

        // 3. how to use it
        FileSystem::write(getcwd() . '/README.md', $readmeTemplateContents);

        $this->symfonyStyle->success('README.md and LICENSE files were added to the root');

        return self::SUCCESS;
    }
}
