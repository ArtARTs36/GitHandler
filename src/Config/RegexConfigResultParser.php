<?php

namespace ArtARTs36\GitHandler\Config;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;

class RegexConfigResultParser implements ConfigResultParser
{
    protected $configurators;

    protected $regex = "/^(.*?)\.(.*)=(.*)/m";

    public function __construct(ConfiguratorsDict $configurators)
    {
        $this->configurators = $configurators;
    }

    /**
     * @inheritDoc
     */
    public function parse(string $raw): SubjectsCollection
    {
        $grouped = $this->grouped($this->splitRaw($raw));

        //

        $data = [];

        foreach ($grouped as $scope => $item) {
            if (! $this->configurators->has($scope)) {
                continue;
            }

            $data[] = $this->configurators->getOrFail($scope)->parse($item);
        }

        return new SubjectsCollection($data);
    }

    /**
     * @inheritDoc
     */
    public function parseByPrefix(string $raw, string $prefix): ConfigSubject
    {
        $grouped = $this->grouped($this->splitRaw($raw));

        //

        if (! array_key_exists($prefix, $grouped)) {
            throw new ConfigDataNotFound($prefix);
        }

        return $this->configurators->getOrFail($prefix)->parse($grouped[$prefix]);
    }

    protected function splitRaw(string $raw): array
    {
        $matches = [];

        preg_match_all($this->regex, $raw, $matches, PREG_SET_ORDER, 0);

        return $matches;
    }

    /**
     * @return array<string, array<string, string>
     */
    protected function grouped(array $matches): array
    {
        $grouped = [];

        foreach ($matches as $match) {
            [$scope, $field, $value] = array_slice($match, 1);

            $grouped[$scope][$field] = $value;
        }

        return $grouped;
    }
}
