<?php

namespace ArtARTs36\GitHandler\Config;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\Str\Str;

/**
 * @internal
 */
class RegexConfigResultParser implements ConfigResultParser
{
    protected $configurators;

    protected $regex = "/^(.*?)\.(.*)=(.*)/m";

    /**
     * @codeCoverageIgnore
     */
    public function __construct(ConfiguratorsDict $configurators)
    {
        $this->configurators = $configurators;
    }

    /**
     * @inheritDoc
     */
    public function parse(Str $raw): SubjectsCollection
    {
        $grouped = $this->grouped($raw->globalMatch($this->regex), 1);

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
    public function parseByPrefix(Str $raw, string $prefix): ConfigSubject
    {
        $grouped = $this->grouped($raw->globalMatch($this->regex), 1);

        //

        if (! array_key_exists($prefix, $grouped)) {
            throw new ConfigDataNotFound($prefix);
        }

        return $this->configurators->getOrFail($prefix)->parse($grouped[$prefix]);
    }

    /**
     * @return array<string, array<string>>
     */
    protected function grouped(array $matches, int $matchOffset): array
    {
        $grouped = [];

        foreach ($matches as $match) {
            [$scope, $field, $value] = array_slice($match, $matchOffset);

            $grouped[$scope][$field] = $value;
        }

        return $grouped;
    }
}
