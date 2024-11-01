<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use TomasVotruba\Handyman\Rector\Rector\CreateMockToDirectNewRector;

return RectorConfig::configure()
    ->withRules([
        CreateMockToDirectNewRector::class,
    ]);
