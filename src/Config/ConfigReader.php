<?php

namespace ArtARTs36\GitHandler\Config;

class ConfigReader
{
    protected $configurators;

    protected $regex = "/^(.*?)\.(.*)=(.*)/m";

    public function __construct(ConfiguratorsDict $configurators)
    {
        $this->configurators = $configurators;
    }

    public function parse(string $raw): array
    {
        $grouped = $this->grouped($this->splitRaw($raw));

        //

        $data = [];

        foreach ($grouped as $scope => $item) {
            try {
                $data[] = $this->configurators->get($scope)->parse($item);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $data;
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
