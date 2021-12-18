<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\GrepCommand;
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
     * @covers \ArtARTs36\GitHandler\Command\Commands\GrepCommand::grep
     */
    public function testGrepEmpty(string $result, string $term): void
    {
        $greps = new GrepCommand($this->mockCommandBuilder, $this->mockCommandExecutor->addSuccess($result));

        self::assertEmpty($greps->grep($term));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\GrepCommand::grep
     */
    public function testGrepFound(): void
    {
        $git = new GrepCommand($this->mockCommandBuilder, $this->mockCommandExecutor->addSuccess(
            "tests/Unit/Data/AuthorTest.php:24:        self::assertFalse();\n".
            "tests/Unit/Data/AuthorTest1.php:24:        self::assertFalse();\n"
        ));

        $matches = $git->grep('Author');

        self::assertCount(2, $matches);
        self::assertEquals([
            'file' => 'tests/Unit/Data/AuthorTest.php',
            'line' => 24,
            'content' => '        self::assertFalse();',
        ], $matches[0]->toArray());
    }
}
