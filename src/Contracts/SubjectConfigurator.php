<?php

namespace ArtARTs36\GitHandler\Contracts;

interface SubjectConfigurator
{
    /**
     * @param array<string, string> $raw
     */
    public function parse(array $raw): ConfigSubject;

    /**
     * @return string
     */
    public function getPrefix(): string;
}
