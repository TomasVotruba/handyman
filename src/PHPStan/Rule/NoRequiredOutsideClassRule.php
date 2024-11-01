<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\PHPStan\Rule;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @see \TomasVotruba\Handyman\Tests\PHPStan\Rule\NoRequiredOutsideClassRule\NoRequiredOutsideClassRuleTest
 *
 * @implements Rule<Class_>
 */
final class NoRequiredOutsideClassRule implements Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Symfony #[Require]/@required should be used only in classes to avoid missuse';

    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        foreach ($node->getAttrGroups() as $attrGroup) {
            dump($attrGroup->attrs);
            die;
        }

        $docComment = $node->getDocComment();
        if ($docComment instanceof Doc && str_contains($docComment->getText(), '@required')) {
            $ruleError = RuleErrorBuilder::message(self::ERROR_MESSAGE)->build();
            return [$ruleError];
        }

        return [];
    }
}
