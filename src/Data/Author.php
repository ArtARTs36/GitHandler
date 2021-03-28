<?php

namespace ArtARTs36\GitHandler\Data;

class Author
{
    public $name;

    public $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function equals(self $author): bool
    {
        return $this->name === $author->name && $this->email === $author->email;
    }

    public function __toString(): string
    {
        return "$this->name <$this->email>";
    }
}
