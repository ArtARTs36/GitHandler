<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Workflow\DumpBuilding;
use ArtARTs36\GitHandler\Workflow\Workflow;

final class WorkflowTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::dumpWith
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::doDump
     */
    public function testDumpWith(): void
    {
        $workflow = $this->makeWorkflow();

        $element = new class implements WorkflowElement {
            public function dump(GitHandler $git): array
            {
                return ['key' => 'value'];
            }

            public function restore(GitHandler $git, array $data): void
            {
                //
            }
        };

        $workflow->dumpWith('file.txt', function (DumpBuilding $building) use ($element) {
            $building->with($element);
        });

        self::assertTrue($this->mockFileSystem->exists('file.txt'));
    }
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::restore
     */
    public function testRestore(): void
    {
        $workflow = $this->makeWorkflow();

        $element = new class implements WorkflowElement {
            public $restored;

            public function dump(GitHandler $git): array
            {
                return ['key' => 'value'];
            }

            public function restore(GitHandler $git, array $data): void
            {
                $this->restored = $data;
            }
        };

        $workflow->dumpWith('file.txt', function (DumpBuilding $building) use ($element) {
            $building->with($element);
        });

        $workflow->restore('file.txt');

        self::assertEquals(['key' => 'value'], $element->restored);
    }

    private function makeWorkflow(): Workflow
    {
        return new Workflow($this->mockGitHandler, $this->mockFileSystem);
    }
}
