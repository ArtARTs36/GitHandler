<?php

namespace ArtARTs36\GitHandler\DocBuilder;

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
                } elseif ($parameter->hasType() && EnumDetector::is($parameter->getType())) {
                    $exampleArgs[] = static::buildEnumArgument($parameter->getType(), $type);
                } elseif ($type === 'bool') {
                    $exampleArgs[] = 'true';
                } else {
                    $exampleArgs[] = "'". $parameter->name ."-test'";
                }
            }

            return $type . ' $' . $parameter->name;
        }, $method->getParameters());

        return new MethodSignature(
            static::buildSignature($method, $params, $docBlock),
            $exampleArgs,
            $suggests
        );
    }

    protected static function buildSignature(\ReflectionMethod $method, array $params, DocBlock $docBlock): string
    {
        $params = implode(', ', $params);


        if ($method->hasReturnType()) {
            $returnType = (string) $method->getReturnType();
        } elseif ($docBlock->hasTag('return')) {
            $returnType = (string) ($docBlock->getTagsByName('return')[0]);
        } else {
            $returnType = 'mixed';
        }

        if ($returnType === '$this') {
            $returnType = 'static';
        }

        return 'public function '. $method->getShortName()
            . '(' . $params . ')'
            . ': ' . $returnType. ';';
    }

    protected static function buildEnumArgument(string $class, string $shortName): string
    {
        $constants = array_flip($class::cases());
        $const = reset($constants);

        return "$shortName::from(" . $shortName . '::' . $const . ")";
    }
}
