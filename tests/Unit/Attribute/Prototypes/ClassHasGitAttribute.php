<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Attribute\Prototypes;

use ArtARTs36\GitHandler\Tests\Support\TestGitAttribute;

class ClassHasGitAttribute
{
    #[TestGitAttribute('test-key2')]
    public $key;
}
