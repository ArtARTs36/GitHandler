<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Core extends AbstractSubject
{
    public $autocrlf;

    public $ignoreCase;

    public $repositoryFormatVersion;

    public $bare;

    public $logAllRefUpdates;

    public function __construct(
        string $autocrlf,
        bool $ignoreCase,
        int $repositoryFormatVersion,
        bool $bare,
        bool $logAllRefUpdates
    ) {
        $this->autocrlf = $autocrlf;
        $this->ignoreCase = $ignoreCase;
        $this->repositoryFormatVersion = $repositoryFormatVersion;
        $this->bare = $bare;
        $this->logAllRefUpdates = $logAllRefUpdates;
    }
}
