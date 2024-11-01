<?php

declare(strict_types=1);

namespace TomasVotruba\Handyman\PHPStan;

use PHPStan\PhpDoc\ResolvedPhpDocBlock;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Constant\ConstantStringType;

final class DoctrineEntityDocumentAnalyser
{
    /**
     * @var string[]
     */
    private const ENTITY_DOCBLOCK_MARKERS = ['@Document', '@ORM\\Document', '@Entity', '@ORM\\Entity'];

    public function __construct(
        private ReflectionProvider $reflectionProvider
    ) {
    }

    public function isEntityClass(ConstantStringType $constantStringType): bool
    {
        if (! $this->reflectionProvider->hasClass($constantStringType->getValue())) {
            return false;
        }

        $classReflection = $this->reflectionProvider->getClass($constantStringType->getValue());
        $resolvedPhpDocBlock = $classReflection->getResolvedPhpDoc();
        if (! $resolvedPhpDocBlock instanceof ResolvedPhpDocBlock) {
            return false;
        }

        foreach (self::ENTITY_DOCBLOCK_MARKERS as $entityDocBlockMarkers) {
            if (str_contains($resolvedPhpDocBlock->getPhpDocString(), $entityDocBlockMarkers)) {
                return true;
            }
        }

        return false;
    }
}
