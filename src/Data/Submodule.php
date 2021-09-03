<?php

namespace ArtARTs36\GitHandler\Data;

use JetBrains\PhpStorm\ArrayShape;

class Submodule
{
    public $name;

    public $path;

    public $url;

    final public function __construct(string $name, string $path, string $url)
    {
        $this->name = $name;
        $this->path = $path;
        $this->url = $url;
    }

    public static function fromArray(
        #[ArrayShape(['name' => 'string', 'path' => 'string', 'url' => 'string'])]
        array $array
    ): self {
        return new self($array['name'], $array['path'], $array['url']);
    }
}
