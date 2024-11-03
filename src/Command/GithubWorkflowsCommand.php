<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GithubWorkflowsCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('github-workflows');
        $this->setDescription('Add typical Github setup to .github/workflows');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->symfonyStyle->title('Creating .github/workflows configs...');

        FileSystem::copy(__DIR__ . '/../../templates/github-workflows', getcwd() . '/.github/workflows', false);

        $this->symfonyStyle->success('Done');

        return self::SUCCESS;
    }
}
