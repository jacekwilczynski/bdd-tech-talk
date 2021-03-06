<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableDoesNotCallOwnPublicMethod;

interface DecoratableInterface
{
    public function run(): void;

    public function build(): void;
}
