<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\StatusCommand;
use ArtARTs36\GitHandler\Enum\StatusResult;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\Str\Str;

final class StatusCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getUntrackedFiles
     */
    public function testGetUntrackedFiles(): void
    {
        $this->mockCommandExecutor->addSuccess(' M src/Contracts/Statusable.php
 M src/Operations/StatusOperations.php
AM tests/Unit/StatusOperationsTest.php
?? .DS_Store
?? "\\ArtARTs36\\GitHandler\\Contracts\\Addable.uml"
?? test.php');

        self::assertEquals([
            '.DS_Store',
            '"\\ArtARTs36\\GitHandler\\Contracts\\Addable.uml"',
            'test.php',
        ], $this->makeStatusCommand()->getUntrackedFiles());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getGroupsByStatusResult
     */
    public function testGetGroupsByStatusResultOnEmpty(): void
    {
        $command = $this->makeStatusCommand();

        //

        self::assertEquals(
            [],
            $this->callMethodFromObject($command, 'getGroupsByStatusResult', new Str(''))
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getGroupsByStatusResult
     */
    public function testGetGroupsByStatusResult(): void
    {
        $command = $this->makeStatusCommand();

        $str = Str::make("A1 valueA1\nA2 valueA2\nA1 twoValueA1");

        self::assertEquals([
            'A1' => ['valueA1', 'twoValueA1'],
            'A2' => ['valueA2'],
        ], $this->callMethodFromObject($command, 'getGroupsByStatusResult', $str));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getAddedFiles
     */
    public function testGetAddedFilesOnEmpty(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertEquals([], $this->makeStatusCommand()->getAddedFiles());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getAddedFiles
     */
    public function testGetAddedFiles(): void
    {
        $this->mockCommandExecutor->addSuccess(StatusResult::GROUP_MODIFIED . " value\n"
            . StatusResult::GROUP_ADDED . " valueAdded1\n"
            . StatusResult::GROUP_ADDED . " valueAdded2");

        $command = $this->makeStatusCommand();

        self::assertEquals([
            'valueAdded1',
            'valueAdded2',
        ], $command->getAddedFiles());
    }

    public function providerForTestGetModifiedFiles(): array
    {
        return [
            [
                '',
                [],
            ],
            [
                StatusResult::GROUP_MODIFIED . " valueModified1\n"
                . StatusResult::GROUP_ADDED . " valueAdded1\n"
                . StatusResult::GROUP_MODIFIED . " valueModified2",
                [
                    'valueModified1',
                    'valueModified2',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestGetModifiedFiles
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::getModifiedFiles
     */
    public function testGetModifiedFiles(string $commandResult, array $files): void
    {
        $this->mockCommandExecutor->addSuccess($commandResult);

        self::assertEquals($files, $this->makeStatusCommand()->getModifiedFiles());
    }

    public function providerForTestHasChanges(): array
    {
        return [
            [
                '',
                false,
            ],
            [
                StatusResult::GROUP_MODIFIED . ' value',
                true,
            ],
            [
                StatusResult::GROUP_ADDED . ' value',
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHasChanges
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::hasChanges
     */
    public function testHasChanges(string $commandResult, bool $state): void
    {
        $this->mockCommandExecutor->addSuccess($commandResult);

        self::assertEquals($state, $this->makeStatusCommand()->hasChanges());
    }

    public function providerForTestStatus(): array
    {
        return [
            [
                'A1 s',
                'A1 s',
                false,
            ],
            [
                'A1 s',
                'A1 s',
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestStatus
     * @covers \ArtARTs36\GitHandler\Command\Commands\StatusCommand::status
     */
    public function testStatus(string $commandResult, string $return, bool $short): void
    {
        $this->mockCommandExecutor->addSuccess($commandResult);

        self::assertEquals($return, $this->makeStatusCommand()->status($short));
    }

    private function makeStatusCommand(): StatusCommand
    {
        return new StatusCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
