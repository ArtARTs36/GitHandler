<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\Str\Str;

interface LogParser
{
    public function parse(Str $raw): ?LogCollection;
}
