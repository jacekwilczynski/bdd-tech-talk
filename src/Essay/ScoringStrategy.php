<?php

declare(strict_types=1);

namespace App\Essay;

interface ScoringStrategy
{
    public function getScore(string $content): int;
}
