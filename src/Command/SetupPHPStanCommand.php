<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\Handyman\ProjectComposerAnalyser;

final class SetupPHPStanCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
        private readonly ProjectComposerAnalyser $projectComposerAnalyser
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('setup-phpstan');
        $this->setDescription('Add typical PHPStan setup, add extension installer to load extensions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->symfonyStyle->title('1. Creating phpstan.neon...');

        if ($this->projectComposerAnalyser->hasPackage('phpstan/phpstan') === false) {
            $this->symfonyStyle->error('Install phpstan/phpstan first');

            return self::FAILURE;
        }

        if (file_exists(getcwd() . '/phpstan.neon')) {
            $this->symfonyStyle->warning('"phpstan.neon" already exists');
        } else {
            FileSystem::write(
                getcwd() . '/phpstan.neon',
                <<<'NEON'
parameters:
    level: 0
    
    paths:
        - src
        # @todo make paths conditional, if they exist
        - tests
NEON
            );

            $this->symfonyStyle->success('Done');
        }

        $this->symfonyStyle->newLine(2);

        $this->symfonyStyle->title('2. Adding phpstan/extension-installer...');

        $allowPluginProcess = Process::fromShellCommandline(
            'composer config allow-plugins.phpstan/extension-installer "true"'
        );
        $allowPluginProcess->mustRun();

        $installExtensionInstallerProcess = Process::fromShellCommandline(
            'composer require --dev phpstan/extension-installer'
        );
        $installExtensionInstallerProcess->mustRun();

        $this->symfonyStyle->success('Done');

        return self::SUCCESS;
    }
}
