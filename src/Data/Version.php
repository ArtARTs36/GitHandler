<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class Version
{
    use ToArray;

    public $full;

    public $major;

    public $minor;

    public $patch;

    public function __construct(string $full, int $major, int $minor, int $patch)
    {
        $this->full = $full;
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    public function __toString(): string
    {
        return $this->full;
    }

    /**
     * @param static|string $comparedVersion
     * @return bool|int
     */
    public function compare($comparedVersion)
    {
        if ($comparedVersion instanceof static) {
            $comparedVersion = $comparedVersion->toTag();
        }

        return version_compare($this->toTag(), $comparedVersion);
    }

    public function toTag(): string
    {
        return implode('.', [
            $this->major,
            $this->minor,
            $this->patch,
        ]);
    }
}
