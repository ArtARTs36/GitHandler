<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Version;

interface Versionable
{
    public function version(): Version;
}
