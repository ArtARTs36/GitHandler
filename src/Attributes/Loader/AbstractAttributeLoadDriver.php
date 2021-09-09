<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;
use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

abstract class AbstractAttributeLoadDriver implements AttributeLoadDriver
{
    /**
     * @param class-string<GitAttribute> $candidate
     * @param array<class-string<GitAttribute>>|null $only
     */
    final protected function isInputToFilterOnly(string $candidate, ?array $only): bool
    {
        return $only === null || in_array($candidate, $only);
    }
}
