<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Config\Subjects\User;

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

        $subject = $git->getConfigSubject('user');

        self::assertInstanceOf(User::class, $subject);
        self::assertEquals('artem', $subject->name);
        self::assertEquals('artem@artem.ru', $subject->email);
    }
}
