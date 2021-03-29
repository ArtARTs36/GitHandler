<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;

interface ConfigResultParser
{
    /**
     * @param string $raw - raw response from git
     * @throws \ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound
     */
    public function parse(string $raw): SubjectsCollection;

    /**
     * @throws ConfigDataNotFound
     */
    public function parseByPrefix(string $raw, string $prefix): ConfigSubject;
}
