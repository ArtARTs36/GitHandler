<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;
use phpDocumentor\Reflection\DocBlock;

class MethodSignatureBuilder
{
    protected static $placeholders = [
        'branch' => 'master',
        'path' => '/path/to/file',
        'attributes' => "['export-ignore']",
    ];

    public static function build(\ReflectionMethod $method, DocBlock $docBlock): MethodSignature
    {
        $suggests = [];
        $exampleArgs = [];
        $needFindExamplesArgs = true;

        if (($docArgs = $docBlock->getTagsByName('exampleArguments')) && ! empty($docArgs)) {
            $exampleArgs = array_map(function (string $arg) {
                return "'$arg'";
            }, $docArgs[0]->getArguments());

            $needFindExamplesArgs = false;
        }

        $params = array_map(function (\ReflectionParameter $parameter) use (
            &$suggests,
            $docBlock,
            &$exampleArgs,
            $needFindExamplesArgs
        ) {
            if ($parameter->hasType()) {
                $parts = explode("\\", $parameter->getType());

                if (Str::contains($parameter->getType(), 'ArtARTs36\\GitHandler\\')) {
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

            if ($needFindExamplesArgs) {
                if (array_key_exists($parameter->name, static::$placeholders)) {
                    if ($type === 'array') {
                        $exampleArgs[] = static::$placeholders[$parameter->name];
                    } else {
                        $exampleArgs[] = "'" . static::$placeholders[$parameter->name] . "'";
                    }
                } else {
                    if ($type === 'int') {
                        $exampleArgs[] = 1;
                    } elseif ($parameter->hasType() && EnumDetector::is($parameter->getType())) {
                        $exampleArgs[] = static::buildEnumArgument($parameter->getType(), $type);
                    } elseif ($type === 'bool') {
                        $exampleArgs[] = 'true';
                    } elseif (($callableTmp = CallableTemplate::buildExampleArgument($parameter, $docBlock))
                        && $callableTmp !== null) {
                        $exampleArgs[] = $callableTmp;
                    } else {
                        $exampleArgs[] = "'" . $parameter->name . "-test'";
                    }
                }
            }

            if ($parameter->allowsNull() && Str::firstSymbol($parameter->name) !== '?' && $parameter->hasType()) {
                $type = '?' . $type;
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

        if ($docBlock->hasTag('return')) {
            $returnType = (string) ($docBlock->getTagsByName('return')[0]->getType());
        } elseif ($method->hasReturnType()) {
            $type = $method->getReturnType();

            $returnType = (string) $type;

            if ($type->allowsNull() && Str::firstSymbol($returnType) !== '?') {
                $returnType = '?' . $returnType;
            }
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
