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
        $a = Money::fromFloat(0.1);
        $b = Money::fromFloat(0.2);
        $sum = $a->add($b);

        self::assertEqualsWithDelta(0.3, $sum->toFloat(), 0.0000000000000000000001);
    }
}
