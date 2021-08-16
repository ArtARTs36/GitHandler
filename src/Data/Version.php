<?php

namespace ArtARTs36\GitHandler\Data;

class Version
{
    public $full;

    public $major;

    public $minor;

    public $patch;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $full, int $major, int $minor, int $patch)
    {
        $this->full = $full;
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    public function __toString()
    {
        return $this->full;
    }
}
