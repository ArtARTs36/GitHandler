<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Instaweb extends AbstractSubject
{
    public $local;

    public $httpd;

    public $port;

    public $browser;

    public $modulePath;

    public function __construct(
        bool $local,
        string $httpd,
        int $port,
        string $browser,
        string $modulePath
    ) {
        $this->local = $local;
        $this->httpd = $httpd;
        $this->port = $port;
        $this->browser = $browser;
        $this->modulePath = $modulePath;
    }
}
