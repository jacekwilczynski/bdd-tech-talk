<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableNotInstantiated;

use Shopware\Core\System\Annotation\Concept\ExtensionPattern\Decoratable;

/**
 * @Decoratable
 */
class DecoratableClass implements DecoratableInterface
{
}
