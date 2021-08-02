<?php

namespace ArtARTs36\GitHandler\Config\Configurators;

use ArtARTs36\GitHandler\Config\Subjects\Branch;
use ArtARTs36\GitHandler\Config\Subjects\LinkBranch;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;

class BranchConfigurator implements SubjectConfigurator
{
    public function parse(array $raw): ConfigSubject
    {
        $parts = array_chunk($raw, 2, true);
        $branches = [];

        foreach ($parts as $part) {
            $branchMerge = $branchRemote = $branchName = '';

            foreach ($part as $identity => $url) {
                $nameParts = explode('.', $identity);

                $branchName = implode('.', array_slice($nameParts, 0, -1));
                $urlType = end($nameParts); // merge | remote

                if ($urlType === 'merge') {
                    $branchMerge = $url;
                } elseif ($urlType === 'remote') {
                    $branchRemote = $url;
                }
            }

            $branches[$branchName] = new LinkBranch($branchRemote, $branchMerge);
        }

        return new Branch($branches);
    }

    public function getPrefix(): string
    {
        return 'branch';
    }
}
