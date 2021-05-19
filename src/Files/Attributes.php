<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Data\Attribute;
use ArtARTs36\Str\Str;

class Attributes extends GitFile
{
    /**
     * @return array<Attribute>
     */
    public function all(): array
    {
        if (! $this->fileExists()) {
            return [];
        }

        $attributes = [];

        foreach ($this->getContent()->lines() as $line) {
            $parts = $line->deleteUnnecessarySpaces()->explode(' ');

            if ($parts->isEmpty() || $parts->count() < 2) {
                continue;
            }

            $attributes[] = new Attribute($parts->first(), $parts->slice(1)->toStrings());
        }

        return $attributes;
    }

    public function addExportIgnore(string ...$paths): bool
    {
        return $this->add('export-ignore', $paths);
    }

    public function add(string $attribute, array $patterns): bool
    {
        $content = $this->fileExists() ? $this->getContent() : Str::fromEmpty();

        if ($content->isEmpty()) {
            $content = $content->appendLine('');
        }

        return $this->createFile($content->append($this->wraps($patterns, $attribute)));
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPathToFile(): string
    {
        return $this->git->getDir()->append('/.gitattributes');
    }

    protected function wraps(array $values, string $attribute): string
    {
        $content = '';

        foreach ($values as $value) {
            $content .= $this->wrap($value, $attribute);
        }

        return $content;
    }

    protected function wrap(string $value, string $attribute): string
    {
        return $value . "\t\t" . $attribute;
    }
}
