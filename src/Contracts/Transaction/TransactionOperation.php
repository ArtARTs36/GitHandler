<?php

namespace ArtARTs36\GitHandler\Contracts\Transaction;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface TransactionOperation
{
    /**
     * @return mixed
     */
    public function __invoke(GitHandler $handler);
}
