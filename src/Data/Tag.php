<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;

class Tag implements Arrayable
{
    use ToArray;

    public $author;

    public $date;

    public $commit;

    public $message;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Author $author, \DateTime $date, Commit $commit, string $message)
    {
        $this->author = $author;
        $this->date = $date;
        $this->commit = $commit;
        $this->message = $message;
    }
}
