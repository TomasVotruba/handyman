<?php

declare(strict_types=1);

namespace Symfony\Component\EventDispatcher;

if (interface_exists(EventDispatcherInterface::class)) {
    return;
}

interface EventDispatcherInterface
{
}
