<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class HomePageBuilder
{
    protected $stubs;

    protected $devCommands;

    private $codeCounts;

    public function __construct(
        StubLoader $stubs,
        DevelopmentCommandsTableBuilder $devCommands,
        CodeCountsBuilder $codeCounts
    ) {
        $this->stubs = $stubs;
        $this->devCommands = $devCommands;
        $this->codeCounts = $codeCounts;
    }

    /**
     * @param array<Page> $pages
     */
    public function build(array $pages): string
    {
        return $this->stubs->load('readme.md')->render([
            'pages' => implode("\n", array_map(function (Page $page) {
                return '* '. Markdown::link($page->title, 'docs/'. $page->file);
            }, $pages)),
            'dev-commands' => $this->devCommands->build(),
            'code-counts' => $this->codeCounts->build(),
        ]);
    }
}
