<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitRemoteCommand;
use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\Str\Str;

class MockHasRemotes implements HasRemotes
{
    private $push;

    private $fetch;

    public function __construct(string $fetch, ?string $push = null)
    {
        $this->fetch = $fetch;
        $this->push = $push;
    }

    public function remotes(): GitRemoteCommand
    {
        return new class($this->fetch, $this->push ?? $this->fetch) implements GitRemoteCommand {
            private $fetch;

            private $push;

            public function __construct(string $fetch, string $push)
            {
                $this->fetch = $fetch;
                $this->push = $push;
            }

            public function showRemote(): Remotes
            {
                return new Remotes(new Str($this->fetch), new Str($this->push));
            }

            public function addRemote(string $shortName, string $url): bool
            {
                return true;
            }

            public function removeRemote(string $shortName): bool
            {
                return true;
            }

            public function hasAnyRemoteUrl(string $url): bool
            {
                return true;
            }
        };
    }
}
