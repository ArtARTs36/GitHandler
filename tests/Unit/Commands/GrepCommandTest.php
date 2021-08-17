<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands\CommandGroup;

use ArtARTs36\GitHandler\Command\Groups\GrepCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class GrepCommandTest extends GitTestCase
{
    public function providerForTestGrepEmpty(): array
    {
        return [
            ['', 'term'], // grep empty
            ['tests/Unit/Data/AuthorTest.php:24\n', 'test'], // not found by regular expression
        ];
    }

    /**
     * @dataProvider providerForTestGrepEmpty
     * @covers \ArtARTs36\GitHandler\Command\Groups\GrepCommand::grep
     */
    public function testGrepEmpty(string $result, string $term): void
    {
        $greps = new GrepCommand($this->mockCommandBuilder, $this->mockCommandExecutor->nextOk($result));

        self::assertEmpty($greps->grep($term));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\GrepCommand::grep
     */
    public function testGrepFound(): void
    {
        $git = new GrepCommand($this->mockCommandBuilder, $this->mockCommandExecutor->nextOk(
            "tests/Unit/Data/AuthorTest.php:24:        self::assertFalse();\n"
        ));

        $matches = $git->grep('Author');

        self::assertArrayHasKey(0, $matches);
        self::assertEquals('tests/Unit/Data/AuthorTest.php', $matches[0]->file);
        self::assertEquals(24, $matches[0]->line);
        self::assertEquals('        self::assertFalse();', $matches[0]->content);
    }
}
