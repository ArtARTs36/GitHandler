<?php

namespace ArtARTs36\GitHandler\Contracts\Config;

use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

interface ConfigAttribute extends GitAttribute
{
    public function __toString(): string;
}
