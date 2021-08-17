<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\CommandGroups;

use ArtARTs36\GitHandler\Command\Groups\HelpCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class HelpCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HelpCommand::get
     */
    public function testGet(): void
    {
        $help = new HelpCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->nextOk('help information')
        );

        self::assertEquals('help information', $help->get());
    }
}
