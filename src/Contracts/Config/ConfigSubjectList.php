<?php

namespace ArtARTs36\GitHandler\Contracts\Config;

interface ConfigSubjectList extends \IteratorAggregate, ConfigSubject
{
    /**
     * @return iterable<string, ConfigSubject>
     */
    public function getIterator(): iterable;
}
