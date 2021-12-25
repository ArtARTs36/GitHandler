<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;

class CodeCountsBuilder
{
    private $statist;

    private $paths;

    /**
     * @param array<string, string> $paths
     */
    public function __construct(
        FolderStatist $statist,
        array $paths
    ) {
        $this->statist = $statist;
        $this->paths = $paths;
    }

    public function build(): string
    {
        $content = '';

        foreach ($this->paths as $type => $path) {
            $statistic = $this->statist->calculate($path);

            $content .= Markdown::tableLine([
                Str::upFirstSymbol($type),
                $statistic->codeFiles,
                $statistic->codeLines,
            ]) . "\n";
        }

        return $content;
    }
}
