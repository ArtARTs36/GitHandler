<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class UntrackedFilesBackupElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement::dump
     */
    public function testDump(): void
    {
        $element = new UntrackedFilesBackupElement();

        $this->mockCommandExecutor->addSuccess("?? .DS_Store");
        $this->mockGitHandler->files()->createFile('.DS_Store', 'ds_store_content');

        self::assertEquals(['.DS_Store' => 'ds_store_content'], $element->dump($this->mockGitHandler));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\UntrackedFilesBackupElement
     * @covers \ArtARTs36\GitHandler\Command\Commands\FileCommand::createPathTo
     */
    public function testRestore(): void
    {
        $element = new UntrackedFilesBackupElement();

        $element->restore($this->mockGitHandler, ['.DS_Store' => 'ds_store_content']);

        self::assertEquals(
            'ds_store_content',
            $this->mockFileSystem->getFileContent($this->mockGitHandler->files()->createPathTo('.DS_Store'))
        );
    }
}
