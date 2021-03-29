<?php

namespace ArtARTs36\GitHandler\Config;

use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;

class ConfiguratorsDict
{
    protected $configurators;

    /**
     * @param array<string, SubjectConfigurator> $configurators
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

        return new static($dict);
    }

    /**
     * @throws SubjectConfiguratorNotFound
     */
    public function get(string $prefix): SubjectConfigurator
    {
        if (! array_key_exists($prefix, $this->configurators)) {
            throw new SubjectConfiguratorNotFound($prefix);
        }

        return $this->configurators[$prefix];
    }
}
