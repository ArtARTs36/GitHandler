<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\StatusResult;
use ArtARTs36\Str\Str;

final class StatusOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::getUntrackedFiles
     */
    public function testGetUntrackedFiles(): void
    {
        $git = $this->mockGit(' M src/Contracts/Statusable.php
 M src/Operations/StatusOperations.php
AM tests/Unit/StatusOperationsTest.php
?? .DS_Store
?? "\\ArtARTs36\\GitHandler\\Contracts\\Addable.uml"
?? test.php');

        self::assertEquals([
            '.DS_Store',
            '"\\ArtARTs36\\GitHandler\\Contracts\\Addable.uml"',
            'test.php',
        ], $git->getUntrackedFiles());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getGroupsByStatusResult
     */
    public function testGetGroupsByStatusResult(): void
    {
        $git = $this->mockGit('');

        //

        self::assertEquals(
            [],
            $this->callMethodFromObject($git, 'getGroupsByStatusResult', new Str(''))
        );

        //

        $str = Str::make("A1 valueA1\nA2 valueA2\nA1 twoValueA1");

        self::assertEquals([
            'A1' => ['valueA1', 'twoValueA1'],
            'A2' => ['valueA2'],
        ], $this->callMethodFromObject($git, 'getGroupsByStatusResult', $str));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getAddedFiles
     */
    public function testGetAddedFiles(): void
    {
        $git = $this->mockGit('');

        self::assertEquals([], $git->getAddedFiles());

        //

        $git = $this->mockGit(
            StatusResult::GROUP_MODIFIED . " value\n"
            . StatusResult::GROUP_ADDED . " valueAdded1\n"
            . StatusResult::GROUP_ADDED . " valueAdded2"
        );

        self::assertEquals([
            'valueAdded1',
            'valueAdded2',
        ], $git->getAddedFiles());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getModifiedFiles
     */
    public function testGetModifiedFiles(): void
    {
        $git = $this->mockGit('');

        self::assertEquals([], $git->getModifiedFiles());

        //

        $git = $this->mockGit(
            StatusResult::GROUP_MODIFIED . " valueModified1\n"
            . StatusResult::GROUP_ADDED . " valueAdded1\n"
            . StatusResult::GROUP_MODIFIED . " valueModified2"
        );

        self::assertEquals([
            'valueModified1',
            'valueModified2',
        ], $git->getModifiedFiles());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::hasChanges
     */
    public function testHasChanges(): void
    {
        $git = $this->mockGit('');

        self::assertFalse($git->hasChanges());

        //

        $git = $this->mockGit(StatusResult::GROUP_MODIFIED . ' value');

        self::assertTrue($git->hasChanges());

        //

        $git = $this->mockGit(StatusResult::GROUP_ADDED . ' value');

        self::assertTrue($git->hasChanges());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::status
     */
    public function testStatus(): void
    {
        $git = $this->mockGit('A1 s');

        self::assertEquals('A1 s', $git->status());

        //

        $git = $this->mockGit('A1 s');

        self::assertEquals('A1 s', $git->status(true));

        //

        $git = $this->mockGit('');

        self::assertTrue($git->status()->isEmpty());

        //

        $git = $this->mockGit(null);

        self::assertTrue($git->status()->isEmpty());
    }
}
