<?php

namespace Doctrine\Bundle\FixturesBundle;

use Doctrine\Common\DataFixtures\FixtureInterface;

if (class_exists(Fixture::class)) {
    return;
}

class Fixture implements FixtureInterface
{
}
