<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Transactions;

use ArtARTs36\GitHandler\Tests\Support\MockPathGenerator;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;
use ArtARTs36\GitHandler\Transactions\ArchiveTransaction;

final class ArchiveTransactionTest extends GitTestCase
{
    /** @var MockPathGenerator */
    private $mockPathGenerator;

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

    /**
     * @covers \ArtARTs36\GitHandler\Transactions\ArchiveTransaction::attempt
     */
    public function testAttemptOk(): void
    {
        $transaction = $this->makeArchiveTransaction();

        $this->mockPathGenerator->setArchivePath('archive.zip');
        $this->mockFileSystem->createFile('archive.zip', '');

        $this->mockCommandExecutor->nextAttemptsOk(3);

        self::assertEquals('transaction-attempt-ok', $transaction->attempt(function () {
            return 'transaction-attempt-ok';
        }));
    }

    private function makeArchiveTransaction(): ArchiveTransaction
    {
        $this->mockPathGenerator = new MockPathGenerator();

        return new ArchiveTransaction(
            $this->mockGitContext,
            $this->mockGitHandler,
            $this->mockFileSystem,
            $this->mockPathGenerator
        );
    }
}
