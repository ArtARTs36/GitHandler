<?php

namespace ArtARTs36\GitHandler\Contracts\Config;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;

interface ConfigSubject extends Arrayable
{
    public function isEmpty(): bool;

    public function name(): string;
}
