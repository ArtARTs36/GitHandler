<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\ConfigCommand;
use ArtARTs36\GitHandler\Config\Configurators\CoreConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\CredentialConfigurator;
use ArtARTs36\GitHandler\Config\Configurators\UserConfigurator;
use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Config\RegexConfigResultParser;
use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class ConfigCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\ConfigCommand::getAll
     * @covers \ArtARTs36\GitHandler\Command\Commands\ConfigCommand::executeConfigList
     */
    public function testGetConfigList(): void
    {
        $this->mockCommandExecutor->nextOk("credential.helper=osxkeychain
user.name=artem
user.email=artem@artem.ru
core.autocrlf=input
");

        self::assertCount(3, $this->makeConfigCommand()->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\ConfigCommand::getSubject
     * @covers \ArtARTs36\GitHandler\Command\Commands\ConfigCommand::executeConfigList
     */
    public function testGetConfigSubject(): void
    {
        $this->mockCommandExecutor->nextOk("credential.helper=osxkeychain
user.name=artem
user.email=artem@artem.ru
core.autocrlf=input
");

        /** @var User $subject */
        $subject = $this->makeConfigCommand()->getSubject('user');

        self::assertInstanceOf(User::class, $subject);
        self::assertEquals('artem', $subject->name);
        self::assertEquals('artem@artem.ru', $subject->email);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\ConfigCommand::set
     */
    public function testSetConfig(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertTrue($this->makeConfigCommand()->set('user', 'name', 'artem', true));
    }

    protected function makeConfigCommand(): ConfigCommand
    {
        return new ConfigCommand(
            new RegexConfigResultParser(ConfiguratorsDict::make([
                new CredentialConfigurator(),
                new UserConfigurator(),
                new CoreConfigurator(),
            ])),
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
