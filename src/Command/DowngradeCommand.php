<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Command;

use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class DowngradeCommand extends Command
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('downgrade');
        $this->setDescription(
            'Prepare setup for downgrading package with Rector on release - rector.php config, Scoper and Github Workflow'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // @todo
        // @todo copy prepared workflow
        // @todo create /build with config
        // @todo update composer.json with no PHP version check

        return self::SUCCESS;
    }
}
