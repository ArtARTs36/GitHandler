<?php

namespace ArtARTs36\GitHandler\Contracts;

interface OriginUrl
{
    public function toCommit(HasRemotes $git, string $hash): string;

    public function toArchive(HasRemotes $git, string $branch = 'master'): string;

    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string;

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string;
}
