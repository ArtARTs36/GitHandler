<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\Str\Str;

final class LoggerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Logger::parse
     */
    public function testParseOnEmptyRaw(): void
    {
        $logger = new Logger();

        self::assertNull($logger->parse(new Str('')));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Logger::parse
     * @covers \ArtARTs36\GitHandler\Logger::hasAuthor
     */
    public function testParse(): void
    {
        $logger = new Logger();

        //

        $result = $logger->parse(
            new Str('* |log-entry|7d0aca97318037b6cbccc7d7169079b9dcfe6d49|2021-04-01 23:28:08 +0300|ArtARTs36|'
            .'temicska99@mail.ru|update readme.md|'
            .'* |log-entry|3ceda5859b20957d47bcbe519317de5ee9db938b|2021-04-01 23:25:19 +0300|ArtARTs36'
            .'|temicska99@mail.ru|support download from bit bucket|
        ')
        );

        self::assertNotNull($result);
        self::assertTrue($this->callMethodFromObject($logger, 'hasAuthor', 'ArtARTs36'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Logger::getOrCreateAuthor
     */
    public function testGetOrCreateAuthor(): void
    {
        $logger = new Logger();

        //

        [$name, $email] = ['Dev', 'test@mail.ru'];

        //

        /** @var Author $author */
        $author = $this->callMethodFromObject($logger, 'getOrCreateAuthor', $name, $email);

        self::assertEquals($name, $author->name);
        self::assertEquals($email, $author->email);

        //

        $authorTwo = $this->callMethodFromObject($logger, 'getOrCreateAuthor', $name, $email);

        self::assertSame($author, $authorTwo);
    }
}
