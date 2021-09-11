<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute\Prototypes;

use ArtARTs36\GitHandler\Tests\Support\TestAttribute;

class ClassHasOtherAttribute
{
    #[TestAttribute('test-key1')]
    public $key;
}
