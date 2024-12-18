<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withDowngradeSets(php72: true)
    ->withSkip([
        // typical tests locations
        '*/Tests/*',
        '*/tests/*',
        __DIR__ . '/../../tests',
    ]);
