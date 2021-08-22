<?php

namespace ArtARTs36\GitHandler\Contracts\Transaction;

use ArtARTs36\GitHandler\Exceptions\GitHandlerException;

/**
 * Git Transactions
 */
interface GitTransaction
{
    /**
     * @param TransactionOperation|\Closure|callable
     * @throws \Throwable
     * @throws GitHandlerException
     * @return mixed
     */
    public function attempt(callable $callback);
}
