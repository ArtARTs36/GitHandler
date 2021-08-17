<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class DocBuilder
{
    protected $reflector;

    protected $pages;

    protected $stubs;

    public function __construct(\ReflectionClass $reflector, StubLoader $stubs)
    {
        $this->reflector = $reflector;
        $this->pages = new DocCommandPageBuilder($stubs);
        $this->stubs = $stubs;
    }

    /**
     * @return array<Page>
     */
    public function build(): array
    {
        $methods = $this->reflector->getMethods();

        $pageClasses = $this->getClassesForPages($methods);

        $pages = [];

        foreach ($pageClasses as [$factoryMethod, $pageClass]) {
            $pages[] = $this->pages->buildFrom($factoryMethod, new \ReflectionClass($pageClass));
        }

        return $pages;
    }

    /**
     * @param \ReflectionMethod[] $methods
     * @return array
     */
    protected function getClassesForPages(array $methods): array
    {
        $classes = [];

        foreach ($methods as $method) {
            if (! $method->hasReturnType()
                || $method->getReturnType()->isBuiltin()
                || ! interface_exists((string) $method->getReturnType())
            ) {
                continue;
            }

            $classes[] = [$method->getShortName(), (string) $method->getReturnType()];
        }

        return $classes;
    }
}
