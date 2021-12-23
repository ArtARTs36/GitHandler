<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Making\MakingPush;

interface PushSetup
{
    /**
     * @return void
     */
    public function __invoke(MakingPush $push);
}
