<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class CreateMockToDirectNewRectorTest extends AbstractRectorTestCase
{
    #[DataProvider('provideData')]
    #[DoesNotPerformAssertions]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule.php';
    }
}
