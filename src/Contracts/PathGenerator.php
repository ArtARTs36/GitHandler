<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Enum\ArchiveFormat;

interface PathGenerator
{
    /**
     * Generate temporary archive path
     */
    public function toArchive(ArchiveFormat $format): string;
}
