<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\FileSystem\JsonFileSystem;
use TomasVotruba\Handyman\FileSystem\TemplateFileSystem;

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
        $readmeFilePath = getcwd() . '/README.md';
        $licenseFilePath = getcwd() . '/LICENSE';

        if (file_exists($readmeFilePath) && file_exists($licenseFilePath)) {
            $this->symfonyStyle->warning('"README.md" and "LICENSE" files already exists');
            return self::SUCCESS;
        }

        if (! file_exists($readmeFilePath)) {
            $composerPackageName = JsonFileSystem::readString(getcwd() . '/composer.json', 'name');

            $readmeTemplateContents = TemplateFileSystem::renderFilePathWithVariables(
                __DIR__ . '/../../templates/README.md',
                [
                    '__COMPOSER_PACKAGE_NAME__' => $composerPackageName,

                ]
            );

            FileSystem::write($readmeFilePath, $readmeTemplateContents);
            $this->symfonyStyle->success('README.md was added');
        }

        if (! file_exists($licenseFilePath)) {
            $licenseTemplateContents = TemplateFileSystem::renderFilePathWithVariables(
                __DIR__ . '/../../templates/LICENSE',
                [
                    '__CURRENT_YEAR__' => date('Y'),

                ]
            );

            FileSystem::write($licenseFilePath, $licenseTemplateContents);
            $this->symfonyStyle->success('LICENSE was added');
        }

        return self::SUCCESS;
    }
}
