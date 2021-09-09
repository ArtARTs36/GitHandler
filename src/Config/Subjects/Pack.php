<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Pack extends AbstractSubject
{
    #[ConfigKey('windowmemory')]
    public $windowMemory;

    #[ConfigKey('packsizelimit')]
    public $packSizeLimit;

    #[ConfigKey('threads')]
    public $threads;

    #[ConfigKey('deltacachesize')]
    public $deltaCacheSize;

    #[ConfigKey('sizelimit')]
    public $sizeLimit;

    #[ConfigKey('window')]
    public $window;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        string $windowMemory,
        string $packSizeLimit,
        int $threads,
        string $deltaCacheSize,
        string $sizeLimit,
        int $window
    ) {
        $this->windowMemory = $windowMemory;
        $this->packSizeLimit = $packSizeLimit;
        $this->threads = $threads;
        $this->deltaCacheSize = $deltaCacheSize;
        $this->sizeLimit = $sizeLimit;
        $this->window = $window;
    }
}
