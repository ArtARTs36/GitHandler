<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Attributes\ConfigKey;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class User extends AbstractSubject
{
    #[ConfigKey('name')]
    public $name;

    #[ConfigKey('email')]
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
