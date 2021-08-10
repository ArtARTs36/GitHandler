<?php

namespace ArtARTs36\GitHandler\Exceptions;

class GivenInvalidUri extends GitHandlerException
{
    public $failedUrl;

    public function __construct(string $url)
    {
        $this->failedUrl = $url;

        parent::__construct("Given invalid uri: ". $url);
    }
}
