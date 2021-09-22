<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class ChangeLogBuilder
{
    private $remote;

    private $stubs;

    public function __construct(GithubRepo $remote, StubLoader $stubs)
    {
        $this->remote = $remote;
        $this->stubs = $stubs;
    }

    public function build(string $path): void
    {
        $tags = $this->remote->getTags();

        $content = '';

        foreach ($tags as $tag) {
            $content .= $this->stubs->load('changelog_release.md')->render([
                'releaseTitle' => $tag->title,
                'releaseVersion' => $tag->tag,
                'releaseDescription' => $tag->markdown,
            ]);
        }

        $content = $this->stubs->load('changelog.md')->render([
            'releases' => $content,
        ]);

        file_put_contents($path, $content);
    }
}
