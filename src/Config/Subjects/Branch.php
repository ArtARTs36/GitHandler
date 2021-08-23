<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Support\ToArray;
use JetBrains\PhpStorm\ArrayShape;

class Branch
{
    use ToArray;

    public $name;

    public $remote;

    public $merge;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $name, string $remote, string $merge)
    {
        $this->name = $name;
        $this->remote = $remote;
        $this->merge = $merge;
    }

    public static function fromLinks(
        string $name,
        #[ArrayShape(['remote' => 'string', 'merge' => 'string'])]
        array $links
    ): self {
        return new self($name, $links['remote'] ?? '', $links['merge'] ?? '');
    }
}
