<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class HomePageBuilder
{
    protected $stubs;

    protected $devCommands;

    public function __construct(StubLoader $stubs, DevelopmentCommandsTableBuilder $devCommands)
    {
        $this->stubs = $stubs;
        $this->devCommands = $devCommands;
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
        ]);
    }
}
