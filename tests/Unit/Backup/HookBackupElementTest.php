<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;

final class HookBackupElementTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\HookBackupElement::dump
     */
    public function testDump(): void
    {
        $element = $this->makeHookWorkflowElement();

        self::assertEquals([], $element->dump($this->mockGitHandler));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Elements\HookBackupElement::restore
     */
    public function testRestore(): void
    {
        $this->mockCommandExecutor->addSuccesses(3);

        $element = $this->makeHookWorkflowElement();

        $element->restore($this->mockGitHandler, [
            Hook::now('pre-push', ''),
            Hook::now('pre-push', ''),
            Hook::now('pre-push', ''),
        ]);

        $this->mockCommandExecutor->assertAttempts(3);
    }

    private function makeHookWorkflowElement(): HookBackupElement
    {
        return new HookBackupElement();
    }
}
