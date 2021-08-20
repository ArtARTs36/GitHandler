<?php

namespace ArtARTs36\GitHandler\Transactions;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Enum\GarbageCollectMode;

class ArchiveTransaction implements GitTransaction
{
    protected $context;

    protected $git;

    protected $files;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitContext $context, GitHandler $git, FileSystem $files)
    {
        $this->context = $context;
        $this->git = $git;
        $this->files = $files;
    }

    public function attempt(callable $callback)
    {
        $archivePath = $this->buildTmpArchivePath();

        $this->git->archives()->packRefs($archivePath);

        try {
            $result = $callback($this->git);

            $this->files->removeFile($archivePath);

            return $result;
        } catch (\Throwable $e) {
            $this->files->removeDir($this->context->getRefsDir());
            $this->git->archives()->unPackRefs($archivePath);
            $this->git->garbage()->collect(GarbageCollectMode::from(GarbageCollectMode::AUTO));

            throw $e;
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function buildTmpArchivePath(): string
    {
        return $this->files->getTmpDir() . DIRECTORY_SEPARATOR
            . 'git-handler-'. time() . '-archive.zip';
    }
}
