<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class TagOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::getTags
     */
    public function testGetTags(): void
    {
        $git = $this->mockGit('0.1.0
0.2.0
0.2.1
');

        self::assertEquals([
            '0.1.0',
            '0.2.0',
            '0.2.1',
        ], $git->getTags());

        //

        $git = $this->mockGit('');

        self::assertEquals([], $git->getTags());
    }
}
