<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Concerns\SwitchFolder;
use ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand;
use ArtARTs36\GitHandler\Data\GitAttributes;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\Str\Facade\Str;
use ArtARTs36\Str\Tab;

class AttributeCommand implements GitAttributeCommand
{
    use SwitchFolder;

    protected $files;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(FileSystem $files, GitContext $context)
    {
        $this->files = $files;
        $this->context = $context;
        $this->seeToFolder($context->getRootDir());
    }

    public function add(string $pattern, array $attributes): void
    {
        $map = $this->getMap();

        $map[$pattern] = array_merge($map[$pattern] ?? [], $attributes);

        $this->saveFromMap($map);
    }

    public function find(string $pattern): ?GitAttributes
    {
        $map = $this->getMap();

        if (! array_key_exists($pattern, $map)) {
            return null;
        }

        return new GitAttributes($pattern, $map[$pattern]);
    }

    /**
     * @return array<string, array<\ArtARTs36\Str\Str>>
     * @throws \ArtARTs36\FileSystem\Contracts\FileNotFound
     */
    public function getMap(): array
    {
        $content = $this->files->getFileContent($this->getPath());

        if (empty(trim($content))) {
            return [];
        }

        $map = [];

        foreach (Str::lines($content . "\n") as $match) {
            $parts = $match->deleteUnnecessarySpaces()->words();

            $map[$parts[0]->__toString()] = array_slice($parts, 1);
        }

        return $map;
    }

    public function getPath(): string
    {
        return $this->folder . DIRECTORY_SEPARATOR . '.gitattributes';
    }

    protected function saveFromMap(array $map): void
    {
        $this->files->createFile($this->getPath(), $this->buildContentFromMap($map));
    }

    protected function buildContentFromMap(array $map): string
    {
        $patterns = array_keys($map);
        $tabs = Tab::addSpaces($patterns);
        $content = '';

        foreach ($patterns as $index => $pattern) {
            $content .= $tabs[$index] . implode(' ', $map[$pattern]);
            $content .= "\n";
        }

        return $content;
    }
}
