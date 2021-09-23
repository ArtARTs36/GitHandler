<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock;

class CallableTemplate
{
    protected static $argTemplates = [
        'TransactionOperation' => 'function (GitHandler $git) {
    $git->merges()->merge(\'master\');
}',
    ];

    public static function buildExampleArgument(
        \ReflectionParameter $parameter,
        DocBlock $methodDoc
    ): ?string {
        if (! ($parameter->hasType() && $parameter->getType() == 'callable')) {
            return null;
        }

        $params = $methodDoc->getTagsByName('param');

        foreach ($params as $param) {
            if ($param->getVariableName() === $parameter->getName()) {
                foreach ($param->getType() as $type) {
                    return static::$argTemplates[$type->getFqsen()->getName()] ?? null;
                }
            }
        }

        return null;
    }
}
