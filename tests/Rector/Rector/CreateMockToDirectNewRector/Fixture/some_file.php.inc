<?php

namespace TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector\Fixture;

use PHPUnit\Framework\TestCase;
use TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector\Source\Table;

final class SomeFileTest extends TestCase
{
    public function test()
    {
        $tableMock = $this->createMock(Table::class);

        $tableMock
            ->expects(self::once())
            ->method('isLocked')
            ->willReturn(true);

        $tableMock
            ->expects(self::once())
            ->method('setLocked')
            ->with(false)
            ->willReturn($tableMock);
    }
}

?>
-----
<?php

namespace TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector\Fixture;

use PHPUnit\Framework\TestCase;
use TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector\Source\Table;

final class SomeFileTest extends TestCase
{
    public function test()
    {
        $table = new \TomasVotruba\Handyman\Tests\Rector\Rector\CreateMockToDirectNewRector\Source\Table();

        $table->setLocked(true);
    }
}

?>
