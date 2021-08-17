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

        [$signature, $suggests] = MethodSignatureBuilder::build($method, $docBlock);

        $suggests = $this->buildSuggests($suggests);

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
            'realGitCommands' => implode("\n", array_map(function (string $command) {
                return "`" . $command . "`";
            }, $gitCommands)),
            'factoryMethodName' => $factoryMethodName,
            'featureMethodName' => $method->getShortName(),
            'featureMethodSignature' => $signature,
            'featureSuggestsClasses' => $suggests,
        ]);
    }

    protected function buildSuggests(array $suggests): string
    {
        if (count($suggests) === 0) {
            return '';
        }

        $message = "See classes: \n";

        foreach ($suggests as $suggestClass) {
            $message .= "\n* $suggestClass";
        }

        return $message;
    }
}
