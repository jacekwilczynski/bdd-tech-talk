<?php

declare(strict_types=1);

namespace App\Essay;

class Evaluation
{
    private int $score;

    public function __construct(int $score)
    {
        $this->score = $score;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
