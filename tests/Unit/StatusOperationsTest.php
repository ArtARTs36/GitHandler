<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

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
}
