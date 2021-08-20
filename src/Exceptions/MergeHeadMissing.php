<?php

namespace ArtARTs36\GitHandler\Exceptions;

class MergeHeadMissing extends CannotMergeAbort
{
    public function __construct()
    {
        parent::__construct('MERGE_HEAD missing');
    }
}
