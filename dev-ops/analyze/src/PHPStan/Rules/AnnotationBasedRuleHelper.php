<?php declare(strict_types=1);

namespace App\Analyze\PHPStan\Rules;

use PHPStan\Reflection\ClassReflection;

class AnnotationBasedRuleHelper
{
    public const DECORATABLE_ANNOTATION = 'Decoratable';

    public static function isClassTaggedWithAnnotation(ClassReflection $class, string $annotation): bool
    {
        $reflection = $class->getNativeReflection();
        $docComment = $reflection->getDocComment();
        if ($docComment === false) {
            return false;
        }

        return $reflection->getDocComment() && strpos($docComment, '@' . $annotation) !== false;
    }
}
