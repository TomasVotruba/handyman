<?php

namespace TomasVotruba\Handyman\Tests\Rector\Rector\SingleMockPropertyTypeRector\Fixture;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TomasVotruba\Handyman\Tests\Rector\Rector\SingleMockPropertyTypeRector\Source\AnyBook;

class UnionTypeMock extends TestCase
{
    private MockObject|AnyBook $anyBook;
}

?>
-----
<?php

namespace TomasVotruba\Handyman\Tests\Rector\Rector\SingleMockPropertyTypeRector\Fixture;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TomasVotruba\Handyman\Tests\Rector\Rector\SingleMockPropertyTypeRector\Source\AnyBook;

class UnionTypeMock extends TestCase
{
    private MockObject $anyBook;
}

?>
