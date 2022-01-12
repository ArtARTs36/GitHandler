<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Support\Logger;
use ArtARTs36\Str\Str;

final class LoggerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\Logger::parse
     */
    public function testParseOnEmptyRaw(): void
    {
        self::assertNull($this->makeLogger()->parse(new Str('')));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\Logger::parse
     * @covers \ArtARTs36\GitHandler\Support\Logger::createAuthor
     * @covers \ArtARTs36\GitHandler\Support\Logger::__construct
     */
    public function testParse(): void
    {
        $logger = $this->makeLogger();

        //

        $result = $logger->parse(
            new Str('* |log-entry|7d0aca97318037b6cbccc7d7169079b9dcfe6d49|2021-04-01 23:28:08 +0300|ArtARTs36|'
            .'temicska99@mail.ru|update readme.md|'
            .'* |log-entry|3ceda5859b20957d47bcbe519317de5ee9db938b|2021-04-01 23:25:19 +0300|ArtARTs36'
            .'|temicska99@mail.ru|support download from bit bucket|
        ')
        );

        self::assertNotNull($result);
        self::assertEquals([
            'commit' => [
                'hash' => '7d0aca97318037b6cbccc7d7169079b9dcfe6d49',
            ],
            'date' => '2021-04-01 23:28:08',
            'author' => [
                'name' => 'ArtARTs36',
                'email' => 'temicska99@mail.ru',
            ],
            'message' => 'update readme.md',
        ], $result->first()->toArray());
    }

    private function makeLogger(): Logger
    {
        return new Logger(new Author\Hydrator());
    }
}
