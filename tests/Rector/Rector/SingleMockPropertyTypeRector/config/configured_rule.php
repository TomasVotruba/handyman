<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use TomasVotruba\Handyman\Rector\Rector\SingleMockPropertyTypeRector;

return RectorConfig::configure()
    ->withRules([
        SingleMockPropertyTypeRector::class,
    ]);
