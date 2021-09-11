<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Workflow\Elements\ConfigCommitWorkflowElement;

final class ConfigWorkflowElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Elements\ConfigCommitWorkflowElement::dump
     */
    public function testDump(): void
    {
        $element = $this->makeConfigWorkflowElement();

        $this->mockCommandExecutor->nextOk('commit.template=path');

        $dump = $element->dump($this->mockGitHandler);

        self::assertEquals('path', $dump['commit']->templatePath);
    }

    private function makeConfigWorkflowElement(): ConfigCommitWorkflowElement
    {
        return new ConfigCommitWorkflowElement();
    }
}
