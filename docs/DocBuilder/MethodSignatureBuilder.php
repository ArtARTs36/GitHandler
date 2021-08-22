<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\GitHandler\Enum\Enumerable;
use phpDocumentor\Reflection\DocBlock;

class MethodSignatureBuilder
{
    protected static $placeholders = [
        'branch' => 'master',
        'path' => '/path/to/file',
    ];

    public static function build(\ReflectionMethod $method, DocBlock $docBlock): MethodSignature
    {
        $suggests = [];
        $exampleArgs = [];

        $params = array_map(function (\ReflectionParameter $parameter) use (&$suggests, $docBlock, &$exampleArgs) {
            if ($parameter->hasType()) {
                $parts = explode("\\", $parameter->getType());

                if (strpos($parameter->getType(), 'ArtARTs36\\GitHandler\\') !== false) {
                    $suggests[] = $parameter->getType();
                }

                $type = end($parts);
            } else {
                $type = 'string';

                foreach ($docBlock->getTagsByName('param') as $tag) {
                    if ($tag->getVariableName() === $parameter->name) {
                        $type = (string) $tag->getType();
                    }
                }
            }

            if (array_key_exists($parameter->name, static::$placeholders)) {
                $exampleArgs[] = "'". static::$placeholders[$parameter->name] . "'";
            } else {
                if ($type === 'int') {
                    $exampleArgs[] = 1;
                } elseif ($parameter->hasType() && static::isEnum($parameter->getType())) {
                    $exampleArgs[] = static::buildEnumArgument($parameter->getType(), $type);
                } elseif ($type === 'bool') {
                    $exampleArgs[] = 'true';
                } else {
                    $exampleArgs[] = "'". $parameter->name ."-test'";
                }
            }

            return $type . ' $' . $parameter->name;
        }, $method->getParameters());

        $params = implode(', ', $params);

        $signature = 'public function '. $method->getShortName()
            . '(' . $params . ')'
            . ': ' . $method->getReturnType() . ';';

        return new MethodSignature($signature, $exampleArgs, $suggests);
    }

    protected static function buildEnumArgument(string $class, string $shortName): string
    {
        $constants = array_flip($class::cases());
        $const = reset($constants);

        return "$shortName::from(" . $shortName . '::' . $const . ")";
    }

    protected static function isEnum(string $class): bool
    {
        return class_exists($class) && array_key_exists(Enumerable::class, class_uses($class)) ?? false;
    }
}
