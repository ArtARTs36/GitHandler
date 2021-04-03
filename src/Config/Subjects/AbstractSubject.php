<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Support\ToArray;

abstract class AbstractSubject implements ConfigSubject
{
    use ToArray;

    public function isEmpty(): bool
    {
        return count(array_filter($this->toArray())) === 0;
    }
}
