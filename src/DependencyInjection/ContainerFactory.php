<?php

namespace TomasVotruba\Handyman\DependencyInjection;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Handyman\Command\AddDevPackagesCommand;
use TomasVotruba\Handyman\Command\GitignoreCommand;

final class ContainerFactory
{
    public static function create(): Container
    {
        $container = new Container();

        $container->singleton(Application::class, function (Container $container): Application {
            $addDevPackagesCommand = $container->make(AddDevPackagesCommand::class);
            $gitignoreCommand = $container->make(GitignoreCommand::class);

            $application = new Application('Handyman');
            $application->add($addDevPackagesCommand);
            $application->add($gitignoreCommand);

            $application->get('help')->setHidden();
            $application->get('completion')->setHidden();
            $application->get('list')->setHidden();

            return $application;
        });

        $container->singleton(SymfonyStyle::class, function (): SymfonyStyle {
            $input = new ArgvInput();
            $output = new ConsoleOutput();
            return new SymfonyStyle($input, $output);
        });

        return $container;
    }
}
