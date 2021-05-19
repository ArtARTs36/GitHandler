<?php

namespace ArtARTs36\GitHandler\Data;

class Attribute
{
    protected $pattern;

    protected $attrs;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $pattern, array $attrs)
    {
        $this->pattern = $pattern;
        $this->attrs = $attrs;
    }

    public function has(string $attr): bool
    {
        return in_array($attr, $this->attrs);
    }

    /**
     * @return array<string>
     */
    public function all(): array
    {
        return $this->attrs;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }
}
