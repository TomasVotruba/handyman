<?php

namespace TomasVotruba\Handyman\Rector\Tests\Rector\CreateMockToDirectNewRector\Fixture;

use In2plane\BulkStorageBundle\Document\MonthlyStock;
use PHPUnit\Framework\TestCase;

final class SomeFileTest extends TestCase
{
    public function test()
    {
        $monthlyStockMock = $this->createMock(MonthlyStock::class);

        $monthlyStockMock
            ->expects(self::once())
            ->method('isLocked')
            ->willReturn(true);

        $monthlyStockMock
            ->expects(self::once())
            ->method('setLocked')
            ->with(false)
            ->willReturn($monthlyStockMock);
    }
}

?>
-----
<?php

namespace TomasVotruba\Handyman\Rector\Tests\Rector\CreateMockToDirectNewRector\Fixture;

use In2plane\BulkStorageBundle\Document\MonthlyStock;
use PHPUnit\Framework\TestCase;

 class SomeFileTest extends TestCase
{
    public function test()
    {
        $monthlyStockMock = new \In2plane\BulkStorageBundle\Document\MonthlyStock();

        $monthlyStockMock->setLocked(true);
    }
}

?>
