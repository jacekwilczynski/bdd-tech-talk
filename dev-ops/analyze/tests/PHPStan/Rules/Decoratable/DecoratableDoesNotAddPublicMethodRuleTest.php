<?php declare(strict_types=1);

namespace App\Analyze\Test\PHPStan\Rules\Decoratable;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use App\Analyze\PHPStan\Rules\Decoratable\DecoratableDoesNotAddPublicMethodRule;

class DecoratableDoesNotAddPublicMethodRuleTest extends RuleTestCase
{
    public function testDecoratableDoesNotAddPublicMethod(): void
    {
        $this->analyse([
            __DIR__ . '/_fixtures/DecoratableDoesNotAddPublicMethod/DecoratableAddPublicMethod.php',
        ], [
            [
                'The service "App\Analyze\Test\PHPStan\Rules\Decoratable\_fixtures\DecoratableDoesNotAddPublicMethod\DecoratableAddPublicMethod" is marked as "@Decoratable", but adds public method "build", that is not defined by any Interface.',
                20,
            ],
        ]);
    }

    public function testNotTaggedClassIsAllowedToAddPublicMethod(): void
    {
        $this->analyse([
            __DIR__ . '/_fixtures/DecoratableDoesNotAddPublicMethod/NotTaggedClassIsAllowedToAddPublicMethod.php',
        ], []);
    }

    protected function getRule(): Rule
    {
        return new DecoratableDoesNotAddPublicMethodRule();
    }
}
