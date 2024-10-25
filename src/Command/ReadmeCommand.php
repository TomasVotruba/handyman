<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\FileSystem\JsonFileSystem;
use TomasVotruba\Handyman\ProjectComposerAnalyser;

final class ReadmeCommand extends Command
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
        private ProjectComposerAnalyser $projectComposerAnalyser
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('readme');
        $this->setDescription('Add README.md and LICENSE files to the root with typical setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (file_exists(getcwd() . '/README.md')) {
            $this->symfonyStyle->warning('"README.md" already exists');
        } else {
            $readmeTemplateContents = FileSystem::read(__DIR__ . '/../../templates/README.md');

            $composerPackageName = JsonFileSystem::read(getcwd() . '/composer.json', 'name');

            // @todo replace value in template

            dump($readmeTemplateContents);
            die;
        }

        // 1. install via composer, dev most likely

        // 2. what it does

        // 3. how to use it

        return self::SUCCESS;
    }
}