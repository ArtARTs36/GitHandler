<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand;

interface HasAttributes
{
    /**
     * Git attributes
     */
    public function attributes(): GitAttributeCommand;
}
