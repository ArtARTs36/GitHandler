<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config\Prototypes;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use ArtARTs36\GitHandler\Config\Subjects\AbstractSubject;

class Car extends AbstractSubject
{
    #[ConfigKey('self_color')]
    public $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }
}
