<?php

namespace ArtARTs36\GitHandler\Transactions;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\PathGenerator;
use ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;
use ArtARTs36\GitHandler\Enum\GarbageCollectMode;

class ArchiveTransaction implements GitTransaction
{
    protected $context;

    protected $git;

    protected $files;

    protected $paths;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitContext $context, GitHandler $git, FileSystem $files, PathGenerator $paths)
    {
        $this->context = $context;
        $this->git = $git;
        $this->files = $files;
        $this->paths = $paths;
    }

    public function attempt(callable $callback)
    {
        $archivePath = $this->paths->toArchive(ArchiveFormat::from(ArchiveFormat::ZIP));

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
}
