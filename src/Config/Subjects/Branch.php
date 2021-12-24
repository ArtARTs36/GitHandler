<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use JetBrains\PhpStorm\ArrayShape;
use ArtARTs36\GitHandler\Attributes\ConfigSectionName;

class Branch extends AbstractSubject
{
    #[ConfigSectionName()]
    public $name;

    #[ConfigKey('remote')]
    public $remote;

    #[ConfigKey('merge')]
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

    /**
     * @param array<string, string> $links
     */
    public static function fromLinks(
        string $name,
        #[ArrayShape(['remote' => 'string', 'merge' => 'string'])]
        array $links
    ): self {
        return new self($name, $links['remote'] ?? '', $links['merge'] ?? '');
    }
}
