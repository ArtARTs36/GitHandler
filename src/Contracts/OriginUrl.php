<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Git;

interface OriginUrl
{
    public function toCommit(HasRemotes $git, string $hash): string;
}
