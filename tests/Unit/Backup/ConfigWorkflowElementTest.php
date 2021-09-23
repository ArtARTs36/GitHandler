<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Config\Subjects\ConfigCommit;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;

final class ConfigWorkflowElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::dump
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::__construct
     */
    public function testDump(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->nextOk('commit.template=path');

        $dump = $element->dump($this->mockGitHandler);

        self::assertEquals('path', $dump['commit']->templatePath);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::restore
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement::__construct
     */
    public function testRestore(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->nextOk();

        self::assertNull($element->restore($this->mockGitHandler, [
            ConfigSectionName::COMMIT => new ConfigCommit($path = '/var/commit.template'),
        ]));
    }

    private function makeConfigWorkflowElement(): ConfigBackupElement
    {
        return new ConfigBackupElement();
    }
}
