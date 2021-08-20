<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Contracts\Transaction\TransactionOperation;
use ArtARTs36\GitHandler\Exceptions\GitHandlerException;

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
