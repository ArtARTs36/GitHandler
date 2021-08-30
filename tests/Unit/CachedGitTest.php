<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\CachedGit;

final class CachedGitTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\CachedGit::version
     */
    public function testVersion(): void
    {
        $handler = new CachedGit($this->mockGitHandler);

        $this->mockCommandExecutor->nextOk('git version 2.24.3 (Apple Git-128)');

        $oneInstance = $handler->version();
        $twoInstance = $handler->version();

        self::assertEquals(spl_object_id($oneInstance), spl_object_id($twoInstance));
    }
}
