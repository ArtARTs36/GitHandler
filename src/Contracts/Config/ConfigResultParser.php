<?php

namespace ArtARTs36\GitHandler\Contracts\Config;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\Str\Str;

interface ConfigResultParser
{
    /**
     * @param Str $raw - raw response from git
     * @throws \ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound
     */
    public function parse(Str $raw): SubjectsCollection;

    /**
     * @throws ConfigDataNotFound
     */
    public function parseByPrefix(Str $raw, string $prefix): ConfigSubject;
}
