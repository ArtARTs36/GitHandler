<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Core extends AbstractSubject
{
    public $autocrlf;

    public $ignoreCase;

    public $repositoryFormatVersion;

    public $bare;

    public $logAllRefUpdates;

    public $preComposeUnicode;

    public $fileMode;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        string $autocrlf,
        bool $ignoreCase,
        int $repositoryFormatVersion,
        bool $bare,
        bool $logAllRefUpdates,
        bool $preComposeUnicode,
        bool $fileMode
    ) {
        $this->autocrlf = $autocrlf;
        $this->ignoreCase = $ignoreCase;
        $this->repositoryFormatVersion = $repositoryFormatVersion;
        $this->bare = $bare;
        $this->logAllRefUpdates = $logAllRefUpdates;
        $this->preComposeUnicode = $preComposeUnicode;
        $this->fileMode = $fileMode;
    }
}
