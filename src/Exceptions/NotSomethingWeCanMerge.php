<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

final class NotSomethingWeCanMerge extends CannotMergeException
{
    public function __construct(string $branch)
    {
        $this->failedMergeBranch = $branch;

        parent::__construct("merge: $branch - not something we can merge");
    }
}
