<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\Str\Str;

interface HasDirectory
{
    public function getDir(): Str;
}
