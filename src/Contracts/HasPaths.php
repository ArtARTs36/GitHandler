<?php

namespace ArtARTs36\GitHandler\Contracts;

interface HasPaths
{
    public function getInfoPath(): string;

    public function getHtmlPath(): string;

    public function getManPath(): string;
}
