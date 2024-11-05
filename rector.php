<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/bin', __DIR__ . '/src', __DIR__ . '/tests',])
    ->withSkip([
        '*/Fixture/*',
    ])
    ->withImportNames()
    ->withPreparedSets(
        codeQuality: true,
        codingStyle: true,
        naming: true,
        privatization: true,
        typeDeclarations: true,
        instanceOf: true,
        deadCode: true,
        phpunit: true,
        phpunitCodeQuality: true,
    )
    ->withAttributesSets()
    ->withPhpPolyfill()
    ->withPhpSets();
