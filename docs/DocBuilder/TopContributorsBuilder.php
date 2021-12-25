<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

class TopContributorsBuilder
{
    protected $stubs;

    public function __construct(StubLoader $stubs)
    {
        $this->stubs = $stubs;
    }

    public function build(GitHandler $git): string
    {
        return $this->stubs->load('contributors.md')->render([
            'topTable' => $this->buildTable($git),
        ]);
    }

    protected function buildTable(GitHandler $git): string
    {
        $content = Markdown::tableHeader([
            'Author',
            'Commits',
        ]) . "\n";

        foreach ($git->logs()->getAll()->getAuthorsWithCommits([
            'aukrainskiy@phoenixit.ru' => 'temicska99@mail.ru',
        ]) as $author) {
            $content .= Markdown::tableLine([
                $author->author->name,
                count($author->commits)
            ]) . "\n";
        }

        return $content;
    }
}
