<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Transactions;

use ArtARTs36\GitHandler\Support\TemporaryPathGenerator;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Transactions\ArchiveTransaction;

final class ArchiveTransactionTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Transactions\ArchiveTransaction::attempt
     */
    public function testAttemptFailed(): void
    {
        $transaction = $this->makeArchiveTransaction();

        $this
            ->mockCommandExecutor
            ->nextAttemptsOk(4);

        self::expectException(\LogicException::class);

        $transaction->attempt(function () {
            throw new \LogicException('Test');
        });
    }

    private function makeArchiveTransaction(): ArchiveTransaction
    {
        return new ArchiveTransaction(
            $this->mockGitContext,
            $this->mockGitHandler,
            $this->mockFileSystem,
            new TemporaryPathGenerator($this->mockFileSystem)
        );
    }
}
