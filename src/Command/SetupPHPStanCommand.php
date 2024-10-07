<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\Handyman\ProjectComposerAnalyser;

final class SetupPHPStanCommand extends Command
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
        private ProjectComposerAnalyser $projectComposerAnalyser
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('setup-phpstan');
        $this->setDescription('Add typical PHPStan setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->symfonyStyle->title('Creating phpstan.neon...');

        if ($this->projectComposerAnalyser->hasPackage('phpstan/phpstan') === false) {
            $this->symfonyStyle->error('Install phpstan/phpstan first');

            return self::FAILURE;
        }

        if (file_exists(getcwd() . '/phpstan.neon')) {
            $this->symfonyStyle->error('"phpstan.neon" already exists');

            return self::FAILURE;
        }

        FileSystem::write(getcwd() . '/phpstan.neon',
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

        return self::SUCCESS;
    }
}