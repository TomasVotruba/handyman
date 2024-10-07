<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GitignoreCommand extends Command
{
    public function __construct(
        private SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('gitignore');
        $this->setDescription('Add basic .gitignore');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        FileSystem::write(getcwd() . '/.gitignore', <<<'CONTENTS'
/vendor
composer.lock

# phpunit test results
.phpunit.result.cache
CONTENTS
);

        $this->symfonyStyle->success('.gitignore added');

        return self::SUCCESS;
    }
}