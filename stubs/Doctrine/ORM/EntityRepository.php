<?php

namespace Doctrine\ORM;

if (class_exists(EntityRepository::class)) {
    return;
}

class EntityRepository
{
}
