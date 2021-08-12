<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\CommandGroups;

use ArtARTs36\GitHandler\Command\Groups\HelpCommandGroup;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

class HelpCommandGroupTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HelpCommandGroup::get
     */
    public function testGet(): void
    {
        $help = new HelpCommandGroup(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->nextOk('help information')
        );

        self::assertEquals('help information', $help->get());
    }
}
