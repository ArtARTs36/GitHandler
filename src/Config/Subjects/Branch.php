<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\GitConfigKey;
use JetBrains\PhpStorm\ArrayShape;
use ArtARTs36\GitHandler\Attributes\SectionNameGitConfigKey;

class Branch extends AbstractSubject
{
    #[SectionNameGitConfigKey()]
    public $name;

    #[GitConfigKey('remote')]
    public $remote;

    #[GitConfigKey('merge')]
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
