<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Making\MakingPush;

interface PushSetup
{
    public function __invoke(MakingPush $push);
}
