<?php

declare(strict_types=1);

namespace App\Test\Money;

use App\Money\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /** @test */
    public function canAddMoney(): void
    {
        $a = Money::fromFloat(10.00);
        $b = Money::fromFloat(1.23);
        $sum = $a->add($b);

        self::assertEqualsWithDelta(11.23, $sum->toFloat(), 0.0000000000000000000001);
    }
}
