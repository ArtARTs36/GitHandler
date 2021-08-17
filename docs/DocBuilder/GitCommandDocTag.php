<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

class GitCommandDocTag extends BaseTag
{
    protected $name = 'git-command';

    public static function create(string $body)
    {
        // TODO: Implement create() method.
    }

    public function __toString(): string
    {
        return '';
    }
}
