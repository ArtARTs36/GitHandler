<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;
use Composer\Autoload\ClassLoader;
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

        $signature = MethodSignatureBuilder::build($method, $docBlock);

        $suggests = $this->buildSuggests($signature->suggests);

        if (count($gitCommands) === 0) {
            return $this->stubs->load('page_command_feature_content.md')->render([
                'featureName' => '* ' . $docBlock->getSummary(),
                'factoryMethodName' => $factoryMethodName,
                'featureMethodSignature' => $signature->signature,
                'featureSuggestsClasses' => $suggests,
                'featureMethodName' => $method->getShortName(),
                'featureExampleArguments' => $signature->argsAsLine(),
            ]);
        }

        return $this->stubs->load('page_git_command_feature_content.md')->render([
            'featureName' => $docBlock->getSummary(),
            'realGitCommands' => implode("\n\n", array_map(function (string $command) {
                return Markdown::tag($command);
            }, $gitCommands)),
            'factoryMethodName' => $factoryMethodName,
            'featureMethodName' => $method->getShortName(),
            'featureMethodSignature' => $signature->signature,
            'featureSuggestsClasses' => $suggests,
            'featureExampleArguments' => $signature->argsAsLine(),
        ]);
    }

    protected function buildSuggests(array $suggests): string
    {
        if (count($suggests) === 0) {
            return '';
        }

        $message = "See classes: \n";

        foreach ($suggests as $suggestClass) {
            $classInfo = ClassFinder::find($suggestClass);
            $message .= "\n* [$suggestClass](". $classInfo->projectFilePath . ")";
        }

        return $message;
    }
}
