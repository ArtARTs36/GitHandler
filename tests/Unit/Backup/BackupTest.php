<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Backup;

use ArtARTs36\GitHandler\Backup\Elements\AbstractBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\ConfigBackupElement;
use ArtARTs36\GitHandler\Backup\Elements\HookBackupElement;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Backup\BackupElement;
use ArtARTs36\GitHandler\Tests\Support\IsCalledBackupElement;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Backup\ArrayBackupElementDict;
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

        $workflow = $this->makeBackup([$element]);

        $workflow->dumpOnly('file.txt', ['test-element']);

        self::assertTrue($this->mockFileSystem->exists('file.txt'));
    }

    /**
     * @dataProvider providerForTestDump
     * @covers \ArtARTs36\GitHandler\Backup\Backup::dump
     */
    public function testDump(string $path, array $elements, array $expected): void
    {
        $workflow = $this->makeBackup($elements);

        $workflow->dump($path);

        self::assertEquals($expected, unserialize($this->mockFileSystem->getFileContent($path)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Backup::restore
     * @covers \ArtARTs36\GitHandler\Backup\Backup::doRestore
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

        $workflow = $this->makeBackup([$element, $otherElement]);

        $workflow->dumpOnly('file.txt', ['test-element']);

        $workflow->restore('file.txt');

        self::assertEquals(['key' => 'value'], $element->restored);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Backup\Backup::restoreOnly
     */
    public function testRestoreOnly(): void
    {
        $backup = $this->makeBackup([
            $other = new IsCalledBackupElement('other'),
            $target = new IsCalledBackupElement('target'),
        ]);

        $this->mockFileSystem->createFile('path.txt', serialize([
            IsCalledBackupElement::class => [
                'content' => '123',
            ],
        ]));

        $backup->restoreOnly('path.txt', ['target']);

        self::assertEquals([false, true], [$other->isCalled, $target->isCalled]);
    }

    private function makeBackup(array $elements): Backup
    {
        return new Backup($this->mockGitHandler, $this->mockFileSystem, new ArrayBackupElementDict($elements));
    }
}
