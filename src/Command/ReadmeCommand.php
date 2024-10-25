<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
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
        $this->setDescription('Add README.md file to the root with typical setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 1. install via composer, dev most likely

        // 2. what it does

        // 3. how to use it

        return self::SUCCESS;
    }
}