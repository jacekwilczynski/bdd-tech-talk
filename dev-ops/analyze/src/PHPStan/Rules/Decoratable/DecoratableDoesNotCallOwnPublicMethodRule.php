<?php declare(strict_types=1);

namespace App\Analyze\PHPStan\Rules\Decoratable;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use App\Analyze\PHPStan\Rules\AnnotationBasedRuleHelper;

class DecoratableDoesNotCallOwnPublicMethodRule implements Rule
{
    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @param MethodCall $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$scope->isInClass()) {
            // skip
            return [];
        }

        $class = $scope->getClassReflection();
        if ($class === null || !AnnotationBasedRuleHelper::isClassTaggedWithAnnotation($class, AnnotationBasedRuleHelper::DECORATABLE_ANNOTATION)) {
            return [];
        }

        /** @var Identifier $nodeName */
        $nodeName = $node->name;
        $method = $scope->getType($node->var)->getMethod($nodeName->name, $scope);
        if (!$method->isPublic() || $method->getDeclaringClass()->getName() !== $class->getName()) {
            return [];
        }

        return [
            sprintf(
                'The service "%s" is marked as "@Decoratable", but calls it\'s own public method "%s", which breaks decoration.',
                $class->getName(),
                $method->getName()
            ),
        ];
    }
}
