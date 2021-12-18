<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\FetchCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class FetchCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\FetchCommand::fetch
     * @covers \ArtARTs36\GitHandler\Command\Commands\FetchCommand::buildFetchCommand
     */
    public function testFetchGood(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeFetchCommand()->fetch());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\FetchCommand::fetchAll
     * @covers \ArtARTs36\GitHandler\Command\Commands\FetchCommand::buildFetchCommand
     */
    public function testFetchAllGood(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeFetchCommand()->fetchAll());
    }

    private function makeFetchCommand(): FetchCommand
    {
        return new FetchCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
