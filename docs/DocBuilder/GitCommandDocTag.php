<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

class GitCommandDocTag extends BaseTag
{
    protected $name = 'git-command';

    protected $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public static function create(string $body)
    {
        return new static($body);
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function __toString(): string
    {
        return $this->command;
    }
}
