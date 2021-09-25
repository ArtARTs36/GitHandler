<?php

namespace ArtARTs36\GitHandler\Contracts\Common;

interface Arrayable
{
    /**
     * @return array<string, string>
     */
    public function toArray(): array;
}
