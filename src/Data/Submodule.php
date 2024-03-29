<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;
use JetBrains\PhpStorm\ArrayShape;

class Submodule implements Arrayable
{
    use ToArray;

    public $name;

    public $path;

    public $url;

    final public function __construct(string $name, string $path, string $url)
    {
        $this->name = $name;
        $this->path = $path;
        $this->url = $url;
    }

    /**
     * @param array<string, string> $array
     */
    public static function fromArray(
        #[ArrayShape(['name' => 'string', 'path' => 'string', 'url' => 'string'])]
        array $array
    ): self {
        return new self($array['name'], $array['path'], $array['url']);
    }

    public function equals(self $other): bool
    {
        return $this->name === $other->name;
    }
}
