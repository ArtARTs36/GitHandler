<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock;

class MethodSignatureBuilder
{
    public static function build(\ReflectionMethod $method, DocBlock $docBlock): array
    {
        $suggests = [];

        $params = array_map(function (\ReflectionParameter $parameter) use (&$suggests, $docBlock) {
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

            return $type . ' $' . $parameter->name;
        }, $method->getParameters());

        $params = implode(', ', $params);

        $signature = 'public function '. $method->getShortName()
            . '(' . $params . ')'
            . ': ' . $method->getReturnType() . ';';

        return [$signature, $suggests];
    }
}
