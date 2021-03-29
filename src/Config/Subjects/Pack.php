<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Pack extends AbstractSubject
{
    public $windowMemory;

    public $packSizeLimit;

    public $threads;

    public $deltaCacheSize;

    public $sizeLimit;

    public $window;

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
