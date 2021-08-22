<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use phpDocumentor\Reflection\DocBlock\Tags\BaseTag;

class ExampleArgumentsDocTag extends BaseTag
{
    protected $name = 'exampleArguments';

    protected $raw;

    protected $arguments;

    public function __construct(string $raw, array $arguments)
    {
        $this->raw = $raw;
        $this->arguments = $arguments;
    }

    public static function create(string $body)
    {
        return new static($body, explode(' ', $body));
    }

    /**
     * @return array<string>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function __toString(): string
    {
        return $this->raw;
    }
}
