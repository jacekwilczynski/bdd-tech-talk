<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableDoesNotAddPublicMethod;

interface DecoratableInterface
{
    public function run(): void;
}
