<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\Str\Str;
use ArtARTs36\Str\Tab;

class AttributesFile
{
    /**
     * @return array<string, array<\ArtARTs36\Str\Str>>
     */
    public function buildMap(string $content): array
    {
        if (empty(trim($content))) {
            return [];
        }

        $map = [];

        foreach (Str::make($content)->trim()->lines() as $match) {
            $parts = $match->deleteUnnecessarySpaces()->words();

            $map[(string) $parts->first()] = $parts->slice(1)->toArray();
        }

        return $map;
    }

    /**
     * @param non-empty-array<string, array<string>> $map
     */
    public function buildContent(array $map): string
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
