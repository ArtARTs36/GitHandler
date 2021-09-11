<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

class NativeDriver extends AbstractAttributeLoadDriver
{
    public function fromProperties(\ReflectionClass $class, ?array $only = null): array
    {
        /** @var array<string, GitAttribute> $attributes */
        $attributes = [];

        foreach ($class->getProperties() as $property) {
            // @phpstan-ignore-next-line
            foreach ($property->getAttributes() as $attribute) {
                if ($this->isInputToFilterOnly($attribute->getName(), $only)) {
                    $attributes[$property->getName()] = $attribute->newInstance();
                }
            }
        }

        return $attributes;
    }
}
