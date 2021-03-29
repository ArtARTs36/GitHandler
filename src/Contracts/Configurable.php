<?php

namespace ArtARTs36\GitHandler\Contracts;

interface Configurable
{
    /**
     * @return array<ConfigSubject>
     */
    public function getConfigList(): array;
}
