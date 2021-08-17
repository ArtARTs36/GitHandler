<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;

class MethodSignatureBuilder
{
    public static function build(\ReflectionMethod $method): array
    {
        $suggests = [];

        $params = array_map(function (\ReflectionParameter $parameter) use (&$suggests) {
            if ($parameter->hasType()) {
                $parts = explode("\\", $parameter->getType());

                if (strpos($parameter->getType(), 'ArtARTs36\\GitHandler\\') !== false) {
                    $suggests[] = $parameter->getType();
                }

                $type = end($parts);
            } else {
                $type = 'string';
            }

            return $type . ' $' . $parameter->name;
        }, $method->getParameters());

        $params = implode(', ', $params);

        $signature = 'public function '. $method->getShortName()
            . '(' . $params . ')'
            . ': ' . $method->getReturnType() . ';';

        return [$signature, $suggests];
    }
}
