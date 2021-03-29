<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Support\ToArray;

abstract class AbstractSubject implements ConfigSubject
{
    use ToArray;
}
