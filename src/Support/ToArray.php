<?php

namespace ArtARTs36\GitHandler\Support;

trait ToArray
{
    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function isEmpty(): bool
    {
        return count(array_filter($this->toArray())) === 0;
    }
}
