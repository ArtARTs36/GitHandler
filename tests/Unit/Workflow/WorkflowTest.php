<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Workflow\WorkflowBuilding;
use ArtARTs36\GitHandler\Workflow\Workflow;

final class WorkflowTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::dumpOnly
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::doDump
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::building
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::__construct
     */
    public function testDump(): void
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

            public function identity(): string
            {
                return 'test-element';
            }
        };

        $workflow->building(function (WorkflowBuilding $building) use ($element) {
            $building->with($element);
        });

        $workflow->dumpOnly('file.txt', ['test-element']);

        self::assertTrue($this->mockFileSystem->exists('file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::restore
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::dumpOnly
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::doDump
     * @covers \ArtARTs36\GitHandler\Workflow\Workflow::__construct
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

            public function identity(): string
            {
                return 'test-element';
            }
        };

        $workflow->building(function (WorkflowBuilding $building) use ($element) {
            $building->with($element);
        });

        $workflow->dumpOnly('file.txt', ['test-element']);

        // test array_key_exists

        $workflow->building(function (WorkflowBuilding $building) {
            $building->with(new class implements WorkflowElement {
                public function dump(GitHandler $git): array
                {
                    // TODO: Implement dump() method.
                }

                public function restore(GitHandler $git, array $data): void
                {
                    // TODO: Implement restore() method.
                }

                public function identity(): string
                {
                    // TODO: Implement identity() method.
                }
            });
        });

        //

        $workflow->restore('file.txt');

        self::assertEquals(['key' => 'value'], $element->restored);
    }

    private function makeWorkflow(): Workflow
    {
        return new Workflow($this->mockGitHandler, $this->mockFileSystem, new WorkflowBuilding());
    }
}
