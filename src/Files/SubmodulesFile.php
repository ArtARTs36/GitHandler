<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Data\Submodule;
use ArtARTs36\Str\Str;

class SubmodulesFile
{
    private $regex = '#\[submodule "(?<name>.*)"\]\s*path = (?<path>.*)\n\s*url = (?<url>.*)\n?#';

    public function buildMap(string $content): array
    {
        $modules = [];

        foreach (Str::make($content)->globalMatch($this->regex) as $item) {
            $modules[$item['name']] = Submodule::fromArray($item);
        }

        return $modules;
    }

    /**
     * @param array<string, Submodule> $map
     */
    public function buildContent(array $map): string
    {
        $content = '';

        foreach ($map as $module) {
            $content .= $this->buildSubmoduleContent($module);
        }

        return $content;
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