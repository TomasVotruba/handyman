<?php

namespace TomasVotruba\Handyman\Tests\PHPStan\Rule\SingleArgEventDispatchRule\Source;

class NotEventDispatcher
{
    public function dispatch()
    {
        $args = func_get_args();
    }
}
