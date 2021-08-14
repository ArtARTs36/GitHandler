<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;

interface GitInitCommandGroup
{
    /**
     * equals: git init
     * @throws RepositoryAlreadyExists
     */
    public function init(): bool;

    public function isInit(): bool;
}
