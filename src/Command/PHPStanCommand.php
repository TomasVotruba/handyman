<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\Process\ProcessRunner;
use TomasVotruba\Handyman\ProjectComposerAnalyser;

final class PHPStanCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
        private readonly ProjectComposerAnalyser $projectComposerAnalyser
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('phpstan');
        $this->setDescription('Add typical PHPStan setup, extension installer to load extensions and handy extensions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->projectComposerAnalyser->hasPackage('phpstan/phpstan') === false) {
            ProcessRunner::run('composer require phpstan/phpstan --dev̈́');

            $this->symfonyStyle->note('Installing PHPStan first');
        } else {
            $this->symfonyStyle->success('PHPStan is already installed');
        }

        $phpstanFilePath = getcwd() . '/phpstan.neon';
        if (! file_exists($phpstanFilePath)) {
            $this->symfonyStyle->title('Creating phpstan.neon...');
            FileSystem::write(
                $phpstanFilePath,
                <<<'NEON'
parameters:
    level: 0
    
    paths:
        - src
        # @todo make paths conditional, if they exist
        - tests
NEON
            );

            $this->symfonyStyle->success('phpstan.neon added');
        } else {
            $this->symfonyStyle->success('phpstan.neon already exists');
        }

        $this->addPHPStanExtensionInstaller();

        // @todo decoreate phsptan with extension configuration

        return self::SUCCESS;
    }

    private function addPHPStanExtensionInstaller(): void
    {
        if (! $this->projectComposerAnalyser->hasPackage('phpstan/phpstan')) {
            $this->symfonyStyle->title('Adding phpstan/extension-installer...');

            ProcessRunner::run('composer config allow-plugins.phpstan/extension-installer "true"');
            ProcessRunner::run('composer require --dev phpstan/extension-installer');
        } else {
            $this->symfonyStyle->success('phpstan/extension-installer is already installed');
        }
    }
}
