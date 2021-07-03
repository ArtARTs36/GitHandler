<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class Repo
{
    use ToArray;

    public $name;

    public $user;

    public $url;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $name, string $user, string $url)
    {
        $this->name = $name;
        $this->user = $user;
        $this->url = $url;
    }
}
