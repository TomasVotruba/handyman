<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\Handyman\ProjectComposerAnalyser;

final class AddDevPackagesCommand extends Command
{
    /**
     * @var string[]
     */
    private const PACKAGES = [
        'symplify/easy-coding-standard',
        'tomasvotruba/class-leak',
        'shipmonk/composer-dependency-analyser',
        'rector/swiss-knife',
    ];

    /**
     * @var string[]
     */
    private const PHPSTAN_PACKAGES = [
        # phpstan extensions
        'phpstan/phpstan',
        'phpstan/extension-installer',
        'tomasvotruba/unused-public',
        'tomasvotruba/type-coverage',
        'rector/type-perfect',
    ];

    public function __construct(
        private SymfonyStyle $symfonyStyle,
        private ProjectComposerAnalyser $projectComposerAnalyser
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('add-dev-packages');
        $this->setDescription('Add typical dev packages to composer.json');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $existingRequireDevPackages = $this->projectComposerAnalyser->getDevPackages();

        $missingPackages = array_diff(self::PACKAGES, $existingRequireDevPackages);
        $this->symfonyStyle->title('1. Installing dev tools');
        $this->installPackagesAndReport($missingPackages);

        $missingPHPStanPackages = array_diff(self::PHPSTAN_PACKAGES, $existingRequireDevPackages);
        $this->symfonyStyle->title('2. Installing PHPStan and extensions');
        $this->installPackagesAndReport($missingPHPStanPackages);

        $this->symfonyStyle->newLine(2);
        $this->symfonyStyle->note('Try next command ;)');
        $this->symfonyStyle->writeln('bin/handyman gitignore');
        $this->symfonyStyle->newLine();

        return self::SUCCESS;
    }

    /**
     * @param string[] $packages
     */
    private function installPackagesAndReport(array $packages): void
    {
        if ($packages === []) {
            $this->symfonyStyle->writeln('All packages are already installed');
            $this->symfonyStyle->newLine();
            return;
        }

        $this->symfonyStyle->listing($packages);

        Process::fromShellCommandline('composer require --dev ' . implode(' ', $packages), timeout: 120)->mustRun();

        $this->symfonyStyle->success('Done');
    }
}