<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableDoesNotAddPublicMethod;

use Shopware\Core\System\Annotation\Concept\ExtensionPattern\Decoratable;

/**
 * @Decoratable
 */
class DecoratableAddPublicMethod implements DecoratableInterface
{
    public function __construct()
    {
    }

    public function run(): void
    {
    }

    public function build(): void
    {
    }

    private function test(): void
    {
    }
}
