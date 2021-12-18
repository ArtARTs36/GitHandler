<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\HelpCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class HelpCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HelpCommand::get
     */
    public function testGet(): void
    {
        $help = new HelpCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->addSuccess('help information')
        );

        self::assertEquals('help information', $help->get());
    }
}
