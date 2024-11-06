<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use TomasVotruba\Handyman\DependencyInjection\ContainerFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = ContainerFactory::create();

/** @var Application $application */
$application = $container->get(Application::class);

$argvInput = new ArgvInput();
$consoleOutput = new ConsoleOutput();

$exitStatus = $application->run($argvInput, $consoleOutput);
exit($exitStatus);
