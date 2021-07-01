<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Config\Subjects\User;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

final class ConfigOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::getConfigSubject
     */
    public function testGetConfigSubject(): void
    {
        $git = $this->mockGit("credential.helper=osxkeychain
user.name=artem
user.email=artem@artem.ru
core.autocrlf=input
");

        /** @var User $subject */
        $subject = $git->getConfigSubject('user');

        self::assertInstanceOf(User::class, $subject);
        self::assertEquals('artem', $subject->name);
        self::assertEquals('artem@artem.ru', $subject->email);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::setConfig
     */
    public function testSetConfig(): void
    {
        $git = $this->mockGit(null);

        self::assertTrue($git->setConfig('user', 'name', 'artem'));
        self::assertTrue($git->setConfig('user', 'name', 'artem', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::setConfig
     */
    public function testSetConfigBad(): void
    {
        $git = $this->mockGit('other error');

        self::expectException(UnexpectedException::class);

        $git->setConfig('user', 'name', 'artem');
    }
}
