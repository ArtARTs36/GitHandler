<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\BranchList;
use ArtARTs36\GitHandler\Config\Subjects\Branch;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\Str\Str;

class BranchConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        $parts = array_chunk($raw, 2, true);
        $branches = [];

        foreach ($parts as $part) {
            $branchName = '';
            $links = [];

            foreach ($part as $identity => $url) {
                $nameParts = explode('.', $identity);
                $branchName = strlen($branchName) ? $branchName : $this->buildBranchName($nameParts);
                $links[end($nameParts)] = $url;
            }

            $branches[$branchName] = Branch::fromLinks($branchName, $links);
        }

        return new BranchList($branches);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPrefix(): string
    {
        return 'branch';
    }

    protected function buildBranchName(array $parts): string
    {
        return Str::fromArray(array_slice($parts, 0, -1), '.')
            ->cut(null, strlen($this->getPrefix()) + 1);
    }
}
