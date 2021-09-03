<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\Str\Str;

class SubmodulesFile
{
    private $regex = '#\[submodule "(?<name>.*)"\]\s*path = (?<path>.*)\n\s*url = (?<url>.*)\n?#';

    public function buildMap(string $content): array
    {
        return Str::make($content)->globalMatch($this->regex);
    }
}
