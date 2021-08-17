<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlockFactory;

class DocCommandPageBuilder
{
    protected $stubs;

    protected $docBlocks;

    public function __construct(StubLoader $stubs)
    {
        $this->stubs = $stubs;
        $this->docBlocks = DocBlockFactory::createInstance([
            'git-command' => GitCommandDocTag::class,
        ]);
    }

    public function buildFrom(string $factoryMethodName, \ReflectionClass $reflector): Page
    {
        $stub = $this->stubs->load('page_command.md');

        return new Page($this->buildPageName($reflector), $stub->render([
            'title' => $this->docBlocks->create($reflector)->getSummary(),
            'factoryMethodName' => $factoryMethodName,
            'interfaceName' => $reflector->getName(),
            'interfaceFilePath' => $reflector->getFileName(),
        ]));
    }

    protected function buildPageName(\ReflectionClass $class): string
    {
        return snake_case($class->getShortName()) . '.md';
    }
}
