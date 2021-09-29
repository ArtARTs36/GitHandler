<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock;

class CallableTemplate
{
    protected static $argTemplates = [
        'TransactionOperation' => 'function (GitHandler $git) {
    $git->merges()->merge(\'master\');
}',
        'LogQueryAction' => 'function (LogQuery $query) {
   $query
        ->offset(3)
        ->before(new \DateTime())
        ->join(function (LogQuery $query) {
            $query
                ->offset(1)
                ->limit(5)
                ->after(new \DateTime(\'1 month ago\'));
        });   
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
