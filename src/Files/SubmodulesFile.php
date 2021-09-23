<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Data\Submodule;
use ArtARTs36\Str\Str;

class SubmodulesFile
{
    private $regex = '#\[submodule "(?<name>.*)"\]\s*path = (?<path>.*)\n\s*url = (?<url>.*)\n?#';

    /**
     * @return array<string, Submodule>
     */
    public function buildMap(string $content): array
    {
        $modules = [];

        foreach (Str::make($content)->globalMatch($this->regex) as $item) {
            $modules[$item['name']] = Submodule::fromArray($item);
        }

        return $modules;
    }

    /**
     * @param array<Submodule> $map
     */
    public function buildContent(array $map): string
    {
        return implode('', array_map([$this, 'buildSubmoduleContent'], $map));
    }

    protected function buildSubmoduleContent(Submodule $submodule): string
    {
        return <<<HTML
[submodule "$submodule->name"]
	path = $submodule->path
	url = $submodule->url
HTML;
    }
}
