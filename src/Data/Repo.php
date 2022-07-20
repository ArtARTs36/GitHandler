<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;

class Repo implements Arrayable
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
