<?php

namespace ArtARTs36\GitHandler\Contracts\Attribute;

interface AttributeLoadDriver
{
    public function fromProperties(\ReflectionClass $class): array;
}
