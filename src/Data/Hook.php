<?php

namespace ArtARTs36\GitHandler\Data;

class Hook
{
    public $name;

    public $script;

    public $lastUpdateDate;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $name, string $script, \DateTimeInterface $lastUpdateDate)
    {
        $this->name = $name;
        $this->script = $script;
        $this->lastUpdateDate = $lastUpdateDate;
    }
}
