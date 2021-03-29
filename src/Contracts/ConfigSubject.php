<?php

namespace ArtARTs36\GitHandler\Contracts;

interface ConfigSubject
{
    /**
     * @return array<string, string>
     */
    public function toArray(): array;
}
