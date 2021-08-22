<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Support\ToArray;

abstract class AbstractSubject implements ConfigSubject
{
    use ToArray;

    public function name(): string
    {
        $parts = explode('\\', static::class);

        return mb_strtolower(end($parts));
    }
}
