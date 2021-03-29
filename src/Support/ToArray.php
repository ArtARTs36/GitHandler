<?php

namespace ArtARTs36\GitHandler\Support;

trait ToArray
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
