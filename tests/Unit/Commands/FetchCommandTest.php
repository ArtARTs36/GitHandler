<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\FetchCommand;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

final class FetchCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\FetchCommand::fetch
     * @covers \ArtARTs36\GitHandler\Command\Groups\FetchCommand::buildFetchCommand
     */
    public function testFetchGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeFetchCommand()->fetch());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\FetchCommand::fetchAll
     * @covers \ArtARTs36\GitHandler\Command\Groups\FetchCommand::buildFetchCommand
     */
    public function testFetchAllGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeFetchCommand()->fetchAll());
    }

    private function makeFetchCommand(): FetchCommand
    {
        return new FetchCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}