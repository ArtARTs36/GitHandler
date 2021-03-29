<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\ConfigSubject;

abstract class AbstractSubject implements ConfigSubject
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
