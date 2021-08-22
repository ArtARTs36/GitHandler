<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class AuthorTest extends TestCase
{
    public function providerForTestEquals(): array
    {
        return [
            [
                new Author('test', 'test@mail.ru'),
                new Author('test', 'test@mail.ru'),
                true,
            ],
            [
                new Author('test', 'test@mail.ru'),
                new Author('test', ''),
                false,
            ],
            [
                new Author('test', 'test@mail.ru'),
                new Author('', 'test@mail.ru'),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestEquals
     * @covers \ArtARTs36\GitHandler\Data\Author::equals
     */
    public function testEquals(Author $one, Author $two, bool $expected): void
    {
        self::assertSame($expected, $one->equals($two));
    }

    public function toStringDataProvider(): array
    {
        return [
            [
                'test',
                'test@mail.ru',
                'test <test@mail.ru>',
            ],
        ];
    }

    /**
     * @dataProvider toStringDataProvider
     * @covers \ArtARTs36\GitHandler\Data\Author::__toString()
     * @covers \ArtARTs36\GitHandler\Data\Author::__construct
     */
    public function testToString(string $name, string $email, string $result): void
    {
        self::assertEquals($result, (new Author($name, $email))->__toString());
    }
}
