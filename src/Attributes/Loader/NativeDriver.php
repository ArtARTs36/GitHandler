<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;
use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

class NativeDriver implements AttributeLoadDriver
{
    public function fromProperties(\ReflectionClass $class): array
    {
        /** @var array<string, GitAttribute> $attributes */
        $attributes = [];

        foreach ($class->getProperties() as $property) {
            // @phpstan-ignore-next-line
            foreach ($property->getAttributes() as $attribute) {
                $attributes[] = $attribute->newInstance();
            }
        }

        return $attributes;
    }
}
