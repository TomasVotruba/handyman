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

final class GithubWorkflowsCommand extends Command
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('github-actions');
        $this->setDescription('Add typical Github actions to .github/workflows');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // copy whole directory
        // @todo

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

    /**
     * @return string[]
     */
    private function resolveExistingRequireDevPackages(): array
    {
        $composerJsonContents = FileSystem::read(getcwd() . '/composer.json');
        $composerJson = Json::decode($composerJsonContents, forceArrays: true);

        return array_keys($composerJson['require-dev'] ?? []);
    }
}