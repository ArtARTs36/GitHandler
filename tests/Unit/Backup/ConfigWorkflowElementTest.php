<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Config\Subjects\ConfigCommit;
use ArtARTs36\GitHandler\Enum\ConfigSectionName;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\Elements\ConfigCommitWorkflowElement;

final class ConfigWorkflowElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigCommitWorkflowElement::dump
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigCommitWorkflowElement::__construct
     */
    public function testDump(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->nextOk('commit.template=path');

        $dump = $element->dump($this->mockGitHandler);

        self::assertEquals('path', $dump['commit']->templatePath);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigCommitWorkflowElement::restore
     * @covers \ArtARTs36\GitHandler\Backup\Elements\ConfigCommitWorkflowElement::__construct
     */
    public function testRestore(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->nextOk();

        self::assertNull($element->restore($this->mockGitHandler, [
            ConfigSectionName::COMMIT => new ConfigCommit($path = '/var/commit.template'),
        ]));
    }

    private function makeConfigWorkflowElement(): ConfigCommitWorkflowElement
    {
        return new ConfigCommitWorkflowElement();
    }
}
