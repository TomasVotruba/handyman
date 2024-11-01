<?php

namespace TomasVotruba\Handyman\Tests\PHPStan\Rule\NoRequiredOutsideClassRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use TomasVotruba\Handyman\PHPStan\Rule\NoRequiredOutsideClassRule;

final class NoRequiredOutsideClassRuleTest extends RuleTestCase
{
    #[DataProvider('provideData')]
    public function testRule(string $filePath, array $expectedErrorsWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorsWithLines);
    }

    public static function provideData(): \Iterator
    {
        yield [__DIR__ . '/Fixture/TraitWithRequire.php', [
            [NoRequiredOutsideClassRule::ERROR_MESSAGE, 12]
        ]];

        yield [__DIR__ . '/Fixture/TraitWithRequireAttribute.php', [
            [NoRequiredOutsideClassRule::ERROR_MESSAGE, 12]
        ]];
    }

    protected function getRule(): Rule
    {
        return new NoRequiredOutsideClassRule();
    }
}