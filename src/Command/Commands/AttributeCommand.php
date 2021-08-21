<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Attributes\AttributesFile;
use ArtARTs36\GitHandler\Concerns\SwitchFolder;
use ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand;
use ArtARTs36\GitHandler\Data\GitAttributes;
use ArtARTs36\GitHandler\Data\GitContext;

class AttributeCommand implements GitAttributeCommand
{
    use SwitchFolder;

    protected $files;

    protected $context;

    protected $file;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(FileSystem $files, GitContext $context)
    {
        $this->files = $files;
        $this->context = $context;
        $this->file = new AttributesFile();
        $this->seeToRoot();
    }

    public function add(string $pattern, array $attributes): void
    {
        $map = $this->isFileExists() ? $this->getMap() : [];

        $map[$pattern] = array_unique(array_merge($map[$pattern] ?? [], $attributes));

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

    public function delete(string $pattern): bool
    {
        $map = $this->getMap();

        if (! array_key_exists($pattern, $map)) {
            return false;
        }

        unset($map[$pattern]);

        return $this->saveFromMap($map);
    }

    /**
     * @return array<string, array<\ArtARTs36\Str\Str>>
     * @throws \ArtARTs36\FileSystem\Contracts\FileNotFound
     */
    public function getMap(): array
    {
        $content = $this->files->getFileContent($this->getPath());

        return $this->file->buildMap($content);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPath(): string
    {
        return $this->folder . DIRECTORY_SEPARATOR . '.gitattributes';
    }

    protected function saveFromMap(array $map): bool
    {
        return $this->files->createFile(
            $this->getPath(),
            count($map) === 0 ? '' : $this->file->buildContent($map)
        );
    }

    final protected function isFileExists(): bool
    {
        return $this->files->exists($this->getPath());
    }
}
