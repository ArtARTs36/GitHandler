<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Files\Attributes;
use ArtARTs36\GitHandler\Files\Ignore;

interface GitFiles
{
    public function attributes(): Attributes;

    public function ignore(): Ignore;

    public function manager(): GitFileManager;
}
