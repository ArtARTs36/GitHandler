<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;

class Hook implements Arrayable
{
    use ToArray;

    public $name;

    public $script;

    public $lastUpdateDate;

    public function __construct(string $name, string $script, \DateTimeInterface $lastUpdateDate)
    {
        $this->name = $name;
        $this->script = $script;
        $this->lastUpdateDate = $lastUpdateDate;
    }

    public static function now(string $name, string $script): self
    {
        return new self($name, $script, new \DateTime());
    }

    public function isSample(): bool
    {
        return pathinfo($this->name, PATHINFO_EXTENSION) === 'sample';
    }
}
