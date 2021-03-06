<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use App\Analyze\PHPStan\Rules\Decoratable\DecoratableNotInstantiatedRule;

class DecoratableNotInstantiatedRuleTest extends RuleTestCase
{
    public function testDecoratableImplementsImterface(): void
    {
        $this->analyse([
            __DIR__ . '/_fixtures/DecoratableNotInstantiated/Test.php',
        ], [
            [
                'The service "App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableNotInstantiated\DecoratableClass" is marked as "@Decoratable", but is instantiated, use constructor injection via the DIC instead.',
                9,
            ],
        ]);
    }

    protected function getRule(): Rule
    {
        return new DecoratableNotInstantiatedRule($this->createBroker());
    }
}
