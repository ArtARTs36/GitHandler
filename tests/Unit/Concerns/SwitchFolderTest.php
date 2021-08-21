<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Concerns;

use ArtARTs36\GitHandler\Concerns\SwitchFolder;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class SwitchFolderTest extends GitTestCase
{
    public function testSeeToRoot(): void
    {
        $switchable = $this->makeSwitchFolderObject();

        $switchable->seeToRoot();

        self::assertEquals($this->mockGitContext->getRootDir(), $switchable->getFolder());
    }

    public function testSeeToFolder(): void
    {
        $switchable = $this->makeSwitchFolderObject();

        $switchable->seeToFolder('folder1');

        self::assertEquals(
            $this->mockGitContext->getRootDir() . DIRECTORY_SEPARATOR . 'folder1',
            $switchable->getFolder()
        );
    }

    private function makeSwitchFolderObject()
    {
        return new class($this->mockGitContext) {
            use SwitchFolder;

            private $context;

            public function __construct(GitContext $context)
            {
                $this->context = $context;
            }

            public function getFolder(): ?string
            {
                return $this->folder;
            }
        };
    }
}
