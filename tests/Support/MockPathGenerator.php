<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\GitHandler\Contracts\PathGenerator;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;

class MockPathGenerator implements PathGenerator
{
    protected $paths = [];

    public function setArchivePath(string $path): self
    {
        $this->paths['archive'] = $path;

        return $this;
    }

    public function toArchive(ArchiveFormat $format): string
    {
        return $this->paths['archive'] ?? '';
    }
}
