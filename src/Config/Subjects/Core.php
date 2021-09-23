<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Core extends AbstractSubject
{
    #[ConfigKey('autocrlf')]
    public $autocrlf;

    #[ConfigKey('ignorecase')]
    public $ignoreCase;

    #[ConfigKey('repositoryformatversion')]
    public $repositoryFormatVersion;

    #[ConfigKey('bare')]
    public $bare;

    #[ConfigKey('logallrefupdates')]
    public $logAllRefUpdates;

    #[ConfigKey('precomposeunicode')]
    public $preComposeUnicode;

    #[ConfigKey('filemode')]
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
