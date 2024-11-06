<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\FileSystem\TemplateFileSystem;
use TomasVotruba\Handyman\ValueObject\ComposerJson;

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
        $projectFilePath = getcwd() . '/.github/workflows/code-analysis.yaml';

        if (! file_exists($projectFilePath)) {
            $projectComposerJson = new ComposerJson(getcwd() . '/composer.json');

            TemplateFileSystem::renderFilePathWithVariables(
                __DIR__ . '/../../templates/.github/workflows/code_analysis.yaml',
                [
                    '__PHP_VERSION__' => $projectComposerJson->getPhpVersionString(),
                ],
                $projectFilePath
            );

            $this->symfonyStyle->success('Created .github/workflows/code_analysis.yaml');
        } else {
            $this->symfonyStyle->success('Config .github/workflows/code_analysis.yaml already exists');
        }

        return self::SUCCESS;
    }
}
