<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;

interface Initable
{
    /**
     * equals: git init
     * @throws RepositoryAlreadyExists
     */
    public function init(): bool;

    public function isInit(): bool;
}
