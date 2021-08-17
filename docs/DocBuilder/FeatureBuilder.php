<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlockFactory;

class FeatureBuilder
{
    protected $stubs;

    protected $docBlocks;

    public function __construct(StubLoader $stubs, DocBlockFactory $docBlocks)
    {
        $this->stubs = $stubs;
        $this->docBlocks = $docBlocks;
    }

    public function build(\ReflectionMethod $method, string $factoryMethodName): string
    {
        $docBlock = $this->docBlocks->create($method);

        $gitCommands = $docBlock->getTagsByName('git-command');

        [$signature, $suggests] = MethodSignatureBuilder::build($method);

        $suggests = count($suggests) === 0 ? '' : "See classes: ". implode("\n", $suggests);

        if (count($gitCommands) === 0) {
            return $this->stubs->load('page_command_feature_content.md')->render([
                'featureName' => '* ' . $docBlock->getSummary(),
                'factoryMethodName' => $factoryMethodName,
                'featureMethodSignature' => $signature,
                'featureSuggestsClasses' => $suggests,
            ]);
        }

        return $this->stubs->load('page_git_command_feature_content.md')->render([
            'featureName' => $docBlock->getSummary(),
            'realGitCommand' => (string) $gitCommands[0],
            'factoryMethodName' => $factoryMethodName,
            'featureMethodName' => $method->getShortName(),
            'featureMethodSignature' => $signature,
            'featureSuggestsClasses' => $suggests,
        ]);
    }
}
