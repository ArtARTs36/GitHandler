<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\LogCollection;

interface LogParser
{
    public function parse(string $raw): ?LogCollection;
}
