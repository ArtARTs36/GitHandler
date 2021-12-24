<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Config\Subjects\ConfigCommit;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;

final class ConfigBackupElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::dump
     */
    public function testDump(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockGitHandler->files()->createFile('.git/config', 'a1=b2');

        $dump = $element->dump($this->mockGitHandler);

        self::assertEquals('a1=b2', $dump['content']);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::restore
     */
    public function testRestore(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->addSuccess();

        $element->restore($this->mockGitHandler, [
            'content' => 'a1=b3',
        ]);

        self::assertEquals('a1=b3', $this->mockGitHandler->files()->getContent('.git/config'));
    }

    private function makeConfigWorkflowElement(): ConfigBackupElement
    {
        return new ConfigBackupElement();
    }
}
