<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;
use ArtARTs36\GitHandler\Data\Repo;

class GitUrl
{
    /** @var OriginUrlBuilder */
    private $builder;

    /** @var string */
    private $fetchUrl;

    public function __construct(
        OriginUrlBuilder $builder,
        string $fetchUrl
    ) {
        $this->builder = $builder;
        $this->fetchUrl = $fetchUrl;
    }

    public function toCommit(string $hash): string
    {
        return $this->builder->toCommitFromFetchUrl($this->fetchUrl, $hash);
    }

    public function toArchive(string $branch = 'master'): string
    {
        return $this->builder->toArchiveFromFetchUrl($this->fetchUrl, $branch);
    }

    public function toTag(string $tag): string
    {
        return $this->builder->toTagFromFetchUrl($this->fetchUrl, $tag);
    }

    public function toTagsCompare(string $oneTag, string $twoTag): string
    {
        return $this->builder->toTagsCompareFromFetchUrl($this->fetchUrl, $oneTag, $twoTag);
    }

    public function toFile(string $filePath, string $branch): string
    {
        return $this->builder->toFileFromFetchUrl($this->fetchUrl, $filePath, $branch);
    }

    public function toRepo(): Repo
    {
        return $this->builder->toRepoFromUrl($this->fetchUrl);
    }
}
