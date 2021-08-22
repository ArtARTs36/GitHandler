<?php

namespace ArtARTs36\GitHandler\Contracts\Origin;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Data\Repo;
use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;

interface OriginUrlBuilder
{
    public function toCommit(HasRemotes $git, string $hash): string;

    public function toArchive(HasRemotes $git, string $branch = 'master'): string;

    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string;

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string;

    /**
     * @return array<string>
     */
    public function getAvailableDomains(): array;

    /**
     * @throws GivenInvalidUri
     */
    public function toRepoFromUrl(string $url): Repo;
}
