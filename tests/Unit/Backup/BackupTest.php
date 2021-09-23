<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\BackupElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\BackupBuilding;
use ArtARTs36\GitHandler\Backup\Backup;

final class BackupTest extends GitTestCase
{
    public function providerForTestDump(): array
    {
        return [
            [
                'path/to/file',
                [],
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Backup::dumpOnly
     * @covers \ArtARTs36\GitHandler\Backup\Backup::doDump
     * @covers \ArtARTs36\GitHandler\Backup\Backup::__construct
     */
    public function testDumpOnly(): void
    {
        $element = new class implements BackupElement {
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

        $workflow = $this->makeWorkflow([$element]);

        $workflow->dumpOnly('file.txt', ['test-element']);

        self::assertTrue($this->mockFileSystem->exists('file.txt'));
    }

    /**
     * @dataProvider providerForTestDump
     * @covers \ArtARTs36\GitHandler\Backup\Backup::dump
     */
    public function testDump(string $path, array $elements, array $expected): void
    {
        $workflow = $this->makeWorkflow($elements);

        $workflow->dump($path);

        self::assertEquals($expected, unserialize($this->mockFileSystem->getFileContent($path)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Backup::restore
     * @covers \ArtARTs36\GitHandler\Backup\Backup::dumpOnly
     * @covers \ArtARTs36\GitHandler\Backup\Backup::doDump
     * @covers \ArtARTs36\GitHandler\Backup\Backup::__construct
     */
    public function testRestore(): void
    {
        $element = new class implements BackupElement {
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

        $otherElement = new class implements BackupElement {
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
                return 'other-element';
            }
        };

        $workflow = $this->makeWorkflow([$element, $otherElement]);

        $workflow->dumpOnly('file.txt', ['test-element']);

        $workflow->restore('file.txt');

        self::assertEquals(['key' => 'value'], $element->restored);
    }

    private function makeWorkflow(array $elements): Backup
    {
        return new Backup($this->mockGitHandler, $this->mockFileSystem, new BackupBuilding($elements));
    }
}
