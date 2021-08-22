<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class UserConfiguratorTest extends TestCase
{
    public function providerForTestParse(): array
    {
        return [
            [
                [],
                ['name' => '', 'email' => ''],
            ],
            [
                ['name' => 'artem'],
                ['name' => 'artem', 'email' => ''],
            ],
            [
                ['name' => 'artem', 'email' => 'temicska99@mail.ru'],
                ['name' => 'artem', 'email' => 'temicska99@mail.ru'],
            ],
            [
                ['email' => 'temicska99@mail.ru'],
                ['name' => '', 'email' => 'temicska99@mail.ru'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\UserConfigurator::parse
     */
    public function testParseInstanceof(): void
    {
        $configurator = new UserConfigurator();

        self::assertInstanceOf(User::class, $configurator->parse([]));
    }

    /**
     * @dataProvider providerForTestParse
     * @covers \ArtARTs36\GitHandler\Config\Configurators\UserConfigurator::parse
     */
    public function testParse(array $raw, array $expected): void
    {
        $configurator = new UserConfigurator();
        $user = $configurator->parse($raw);

        self::assertEquals($expected, $user->toArray());
    }
}
