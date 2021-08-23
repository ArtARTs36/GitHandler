<?php

namespace ArtARTs36\GitHandler\Config;

use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

class ConfiguratorsDict implements \IteratorAggregate
{
    protected $configurators;

    /**
     * @param array<string, SubjectConfigurator> $configurators
     * @codeCoverageIgnore
     */
    public function __construct(array $configurators)
    {
        $this->configurators = $configurators;
    }

    /**
     * @param list<SubjectConfigurator> $configurators
     */
    public static function make(array $configurators): self
    {
        $dict = [];

        foreach ($configurators as $configurator) {
            $dict[$configurator->getPrefix()] = $configurator;
        }

        return new self($dict);
    }

    /**
     * @throws SubjectConfiguratorNotFound
     */
    public function getOrFail(string $prefix): SubjectConfigurator
    {
        if (! $this->has($prefix)) {
            throw new SubjectConfiguratorNotFound($prefix);
        }

        return $this->configurators[$prefix];
    }

    public function has(string $prefix): bool
    {
        return array_key_exists($prefix, $this->configurators);
    }

    /**
     * @return \ArrayIterator|iterable<SubjectConfigurator>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->configurators);
    }
}
