<?php

namespace ArtARTs36\GitHandler\Contracts\Config;

interface ConfigSubject
{
    /**
     * @return array<string, string>
     */
    public function toArray(): array;

    public function isEmpty(): bool;

    public function name(): string;
}
