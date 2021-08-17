<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlockFactory;

class DocCommandPageBuilder
{
    protected $stubs;

    protected $docBlocks;

    protected $features;

    public function __construct(StubLoader $stubs, FeatureBuilder $features = null)
    {
        $this->stubs = $stubs;
        $this->docBlocks = DocBlockFactory::createInstance([
            'git-command' => GitCommandDocTag::class,
        ]);
        $this->features = $features ?? new FeatureBuilder($stubs, $this->docBlocks);
    }

    public function buildFrom(string $factoryMethodName, \ReflectionClass $reflector): Page
    {
        $stub = $this->stubs->load('page_command.md');

        return new Page($this->buildPageName($reflector), $stub->render([
            'title' => $this->docBlocks->create($reflector)->getSummary(),
            'factoryMethodName' => $factoryMethodName,
            'interfaceName' => $reflector->getName(),
            'interfaceFilePath' => $reflector->getFileName(),
            'featureList' => $this->buildFeatures($reflector->getMethods(), $factoryMethodName),
        ]));
    }

    protected function buildFeatures(array $methods, string $factoryMethodName): string
    {
        return implode("\n", array_map(function (\ReflectionMethod $method) use ($factoryMethodName) {
            return $this->features->build($method, $factoryMethodName) . "\n---";
        }, $methods));
    }

    protected function buildPageName(\ReflectionClass $class): string
    {
        return snake_case($class->getShortName()) . '.md';
    }
}
