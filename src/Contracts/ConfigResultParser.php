<?php

namespace ArtARTs36\GitHandler\Contracts;

interface ConfigResultParser
{
    /**
     * @param string $raw - raw response from git
     * @return array<ConfigSubject>
     * @throws \ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound
     */
    public function parse(string $raw): array;

    public function parseByPrefix(string $raw, string $prefix): ConfigSubject;
}
