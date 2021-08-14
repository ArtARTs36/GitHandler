<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\AddCommand;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;

final class AddCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\AddCommand::add
     */
    public function testAddOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertTrue($this->makeAddCommand()->add('README.MD', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\AddCommand::add
     */
    public function testAddOnNotFound(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->nextFailed("pathspec 'random.file' did not match any files");

        $this->makeAddCommand()->add('random.file');
    }

    private function makeAddCommand(): AddCommand
    {
        return new AddCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
