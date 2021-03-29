<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class InitOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::init
     */
    public function testInit(): void
    {
        $response = $this->mockGit('error')
            ->init();

        self::assertFalse($response);

        //

        $response = $this->mockGit('Initialized empty Git repository in ')
            ->init();

        self::assertTrue($response);
    }
}
