<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class UserConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\UserConfigurator::parse
     */
    public function testParse(): void
    {
        $configurator = new UserConfigurator();

        //

        $user = $configurator->parse([]);

        self::assertInstanceOf(User::class, $user);
        self::assertTrue($user->isEmpty());
        self::assertEmpty($user->email);
        self::assertEmpty($user->name);

        //

        $user = $configurator->parse([
           'email' => $email = 'test@mail.ru',
        ]);

        self::assertInstanceOf(User::class, $user);
        self::assertFalse($user->isEmpty());
        self::assertEquals($email, $user->email);
        self::assertEmpty($user->name);

        //

        $user = $configurator->parse([
            'email' => $email = 'test@mail.ru',
            'name' => $name = 'test',
        ]);

        self::assertInstanceOf(User::class, $user);
        self::assertFalse($user->isEmpty());
        self::assertEquals($email, $user->email);
        self::assertEquals($name, $user->name);

        //

        $user = $configurator->parse([
            'name' => $name = 'test',
        ]);

        self::assertInstanceOf(User::class, $user);
        self::assertFalse($user->isEmpty());
        self::assertEmpty($user->email);
        self::assertEquals($name, $user->name);
    }
}
