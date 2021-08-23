<?php

namespace ArtARTs36\GitHandler\Enum;

trait Enumerable
{
    /** @var string */
    public $value;

    /**
     * @codeCoverageIgnore
     */
    public static function cases(): array
    {
        static $cases = [];

        if (! array_key_exists(static::class, $cases)) {
            $cases[static::class] = (new \ReflectionClass(static::class))->getConstants();
        }

        return $cases[static::class];
    }

    /**
     * @codeCoverageIgnore
     */
    public static function from(string $value): self
    {
        if (! static::has($value)) {
            throw new \InvalidArgumentException('Invalid Enum Value');
        }

        $enum = new self();
        $enum->value = $value;

        return $enum;
    }

    /**
     * @codeCoverageIgnore
     */
    protected static function has(string $value): bool
    {
        return array_key_exists($value, array_flip(static::cases()));
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString()
    {
        return $this->value;
    }
}
