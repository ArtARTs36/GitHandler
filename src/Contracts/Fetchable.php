<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Fetchable
{
    public function fetch(): void;

    public function fetchAll(): void;
}
