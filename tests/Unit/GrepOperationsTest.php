<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class GrepOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::grep
     */
    public function testGrepEmpty(): void
    {
        // null result

        $git = $this->mockGit(null);

        self::assertEmpty($git->grep('term'));

        // empty result

        $git = $this->mockGit('');

        self::assertEmpty($git->grep(''));

        // not found by regular expression

        $git = $this->mockGit("tests/Unit/Data/AuthorTest.php:24\n");

        self::assertEmpty($git->grep('test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::grep
     */
    public function testGrepFound(): void
    {
        $git = $this->mockGit(
            "tests/Unit/Data/AuthorTest.php:24:        self::assertFalse();\n"
        );

        $matches = $git->grep('Author');

        self::assertArrayHasKey(0, $matches);
        self::assertEquals('tests/Unit/Data/AuthorTest.php', $matches[0]->file);
        self::assertEquals(24, $matches[0]->line);
        self::assertEquals('        self::assertFalse();', $matches[0]->content);
    }
}
