<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Data\Version;

interface Versionable
{
    public function version(): Version;
}
