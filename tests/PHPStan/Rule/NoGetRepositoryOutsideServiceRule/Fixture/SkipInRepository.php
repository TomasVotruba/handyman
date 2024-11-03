<?php

declare(strict_types=1);

namespace PHPStan\Rule\NoGetRepositoryOutsideServiceRule\Fixture;

use Doctrine\ORM\EntityManager;
use PHPStan\Rule\NoGetRepositoryOutsideServiceRule\Source\SomeRandomEntity;

final readonly class SkipInRepository
{
    public function __construct(private EntityManager $entityManager)
    {
        $someRepository = $this->entityManager->getRepository(SomeRandomEntity::class);
    }
}
