<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class User extends AbstractSubject
{
    public $name;

    public $email;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}
