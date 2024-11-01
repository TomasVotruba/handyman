<?php

namespace PHPStan\Rule\NoRequiredOutsideClassRule\Fixture;

use Symfony\Contracts\Service\Attribute\Required;

trait TraitWithRequireAttribute
{
    #[Required]
    public function inject()
    {
    }
}
