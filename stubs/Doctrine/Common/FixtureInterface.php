<?php

namespace Doctrine\Common\DataFixtures;

if (interface_exists(FixtureInterface::class)) {
    return;
}

interface FixtureInterface
{
}
