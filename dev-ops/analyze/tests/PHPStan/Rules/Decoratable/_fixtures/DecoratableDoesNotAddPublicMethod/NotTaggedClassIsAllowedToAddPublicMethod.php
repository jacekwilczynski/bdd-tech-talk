<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableDoesNotAddPublicMethod;

class NotTaggedClassIsAllowedToAddPublicMethod implements DecoratableInterface
{
    public function run(): void
    {
    }

    public function build(): void
    {
    }
}
