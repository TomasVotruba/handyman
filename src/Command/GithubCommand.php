<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\FileSystem\TemplateFileSystem;

final class GithubCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('github');
        $this->setDescription('Add typical Github setup to .github/workflows');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $codeAnalysisFilePath = getcwd() . '/.github/workflows/code-analysis.yaml';
        if (! file_exists($codeAnalysisFilePath)) {
            $fileContents = TemplateFileSystem::renderFilePathWithVariables(
                __DIR__ . '/../../templates/github-workflows/code-analysis.yaml',
                []
            );

            FileSystem::write($codeAnalysisFilePath, $fileContents);
            $this->symfonyStyle->success('Created .github/workflows/code-analysis.yaml');
        } else {
            $this->symfonyStyle->success('Config .github/workflows/code-analysis.yaml already exists');
        }

        return self::SUCCESS;
    }
}
