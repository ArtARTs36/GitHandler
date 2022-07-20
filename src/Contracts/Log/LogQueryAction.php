<?php

namespace ArtARTs36\GitHandler\Contracts\Log;

interface LogQueryAction
{
    public function __invoke(LogQuery $query): void;
}
