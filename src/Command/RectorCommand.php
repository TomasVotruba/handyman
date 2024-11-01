<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class RectorCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('rector');
        $this->setDescription('Add rector.php setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $projectRectorFilePath = getcwd() . '/rector.php';
        if (file_exists($projectRectorFilePath)) {
            $this->symfonyStyle->warning('"rector.php" already exists');
            return self::SUCCESS;
        }

        $readmeTemplateContents = FileSystem::read(__DIR__ . '/../../templates/rector.php');
        FileSystem::write($projectRectorFilePath, $readmeTemplateContents);

        $this->symfonyStyle->success('rector.php file was created');

        return self::SUCCESS;
    }
}
