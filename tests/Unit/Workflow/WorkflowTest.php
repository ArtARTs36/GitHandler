<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Workflow;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Workflow\BackupBuilding;
use ArtARTs36\GitHandler\Workflow\Backup;

final class WorkflowTest extends GitTestCase
{
    public function providerForTestDump(): array
    {
        return [
            [
                'path/to/file',
                function () {
                },
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::dumpOnly
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::doDump
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::building
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::__construct
     */
    public function testDumpOnly(): void
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

        $workflow->building(function (BackupBuilding $building) use ($element) {
            $building->with($element);
        });

        $workflow->dumpOnly('file.txt', ['test-element']);

        self::assertTrue($this->mockFileSystem->exists('file.txt'));
    }

    /**
     * @dataProvider providerForTestDump
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::dump
     */
    public function testDump(string $path, callable $building, array $expected): void
    {
        $workflow = $this->makeWorkflow();

        $workflow
            ->building($building)
            ->dump($path);

        self::assertEquals($expected, unserialize($this->mockFileSystem->getFileContent($path)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::restore
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::dumpOnly
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::doDump
     * @covers \ArtARTs36\GitHandler\Workflow\Backup::__construct
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

        $workflow->building(function (BackupBuilding $building) use ($element) {
            $building->with($element);
        });

        $workflow->dumpOnly('file.txt', ['test-element']);

        // test array_key_exists

        $workflow->building(function (BackupBuilding $building) {
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

    private function makeWorkflow(): Backup
    {
        return new Backup($this->mockGitHandler, $this->mockFileSystem, new BackupBuilding());
    }
}
