<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\LogCollection;

interface Logable
{
    public function log(): ?LogCollection;
}
