<?php

namespace ArtARTs36\GitHandler\Contracts\Transaction;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface TransactionOperation
{
    public function __invoke(GitHandler $handler);
}
