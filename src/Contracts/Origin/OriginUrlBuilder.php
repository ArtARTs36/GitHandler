<?php

namespace ArtARTs36\GitHandler\Contracts\Origin;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Data\Repo;
use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;

interface OriginUrlBuilder
{
    /**
     * Build url to commit page on remote hosting
     */
    public function toCommit(HasRemotes $git, string $hash): string;

    /**
     * Build url to archive page on remote hosting
     */
    public function toArchive(HasRemotes $git, string $branch = 'master'): string;

    /**
     * Build url to commit page on remote hosting
     */
    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string;

    /**
     * Build url to archive page on remote hosting
     */
    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string;

    /**
     * Build url to tag page on remote hosting
     */
    public function toTagFromFetchUrl(string $fetchUrl, string $tag): string;

    /**
     * @return array<string>
     */
    public function getAvailableDomains(): array;

    /**
     * Create Data Object "Repo" by repository url
     * @throws GivenInvalidUri
     */
    public function toRepoFromUrl(string $url): Repo;
}
