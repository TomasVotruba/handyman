<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\Tests\PHPStan\Rule\NoAbstractControllerConstructorRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use TomasVotruba\Handyman\PHPStan\Rule\NoAbstractControllerConstructorRule;

final class NoAbstractControllerConstructorRuleTest extends RuleTestCase
{
    /**
     * @param mixed[] $expectedErrorMessagesWithLines
     */
    #[DataProvider('provideData')]
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public static function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/SomeAbstractController.php', [[
            NoAbstractControllerConstructorRule::ERROR_MESSAGE,
            7,
        ]]];

        yield [__DIR__ . '/Fixture/SkipNonAbstractController.php', []];
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(NoAbstractControllerConstructorRule::class);
    }
}
