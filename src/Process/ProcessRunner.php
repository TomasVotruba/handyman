<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Process;

use Symfony\Component\Process\Process;

final class ProcessRunner
{
    public static function run(string $command): void
    {
        $process = Process::fromShellCommandline($command);
        $process->mustRun();
    }
}
