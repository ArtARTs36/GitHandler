<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;

final class HookWorkflowElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement::dump
     */
    public function testDump(): void
    {
        $element = $this->makeHookWorkflowElement();

        self::assertEquals([], $element->dump($this->mockGitHandler));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement::restore
     */
    public function testRestore(): void
    {
        $this->mockCommandExecutor->nextAttemptsOk(3);

        $element = $this->makeHookWorkflowElement();

        $element->restore($this->mockGitHandler, [
            Hook::now('pre-push', ''),
            Hook::now('pre-push', ''),
            Hook::now('pre-push', ''),
        ]);

        $this->mockCommandExecutor->assertAttempts(3);
    }

    private function makeHookWorkflowElement(): HookWorkflowElement
    {
        return new HookWorkflowElement();
    }
}
