<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitPathCommandGroup
{
    public function info(): string;

    public function html(): string;

    public function man(): string;
}
