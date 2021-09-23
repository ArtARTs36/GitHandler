<?php

namespace ArtARTs36\GitHandler\Contracts\Attribute;

interface AttributeLoadDriver
{
    /**
     * @param array|null $only
     * @return array<string, GitAttribute>
     */
    public function fromProperties(\ReflectionClass $class, ?array $only = null): array;
}
