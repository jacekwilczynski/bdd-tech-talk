<?php

declare(strict_types=1);

namespace App\Money;

class Money
{
    private float $value;

    private function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromFloat(float $value): Money
    {
        return new Money($value);
    }

    public function add(Money $other): Money
    {
        return Money::fromFloat($this->value + $other->value);
    }

    public function toFloat(): float
    {
        return $this->value;
    }
}
