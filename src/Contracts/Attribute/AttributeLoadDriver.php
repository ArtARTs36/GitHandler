<?php

namespace ArtARTs36\GitHandler\Contracts\Attribute;

interface AttributeLoadDriver
{
    /**
     * @return array<string, GitAttribute>
     */
    public function fromProperties(\ReflectionClass $class): array;
}
