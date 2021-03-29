<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class User extends AbstractSubject
{
    public $name;

    public $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}
