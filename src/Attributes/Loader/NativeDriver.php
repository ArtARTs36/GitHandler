<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;

class NativeDriver implements AttributeLoadDriver
{
    public function fromProperties(\ReflectionClass $class): array
    {
        $attributes = [];

        foreach ($class->getProperties() as $property) {
            foreach ($property->getAttributes() as $attribute) {
                $attributes[] = $attribute->newInstance();
            }
        }

        return $attributes;
    }
}
