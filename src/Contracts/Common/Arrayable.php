<?php

namespace ArtARTs36\GitHandler\Contracts\Common;

interface Arrayable
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
