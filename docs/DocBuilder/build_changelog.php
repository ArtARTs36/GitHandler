<?php

use ArtARTs36\GitHandler\DocBuilder\ChangeLogBuilder;

require_once __DIR__ . '/../../vendor/autoload.php';

$repo = new \ArtARTs36\GitHandler\DocBuilder\GithubRepo(
    new \GuzzleHttp\Client(),
    'api.github.com',
    'artarts36',
    'GitHandler',
    getenv('GITHUB_API_TOKEN')
);

$files = new \ArtARTs36\GitHandler\Support\LocalFileSystem();

$builder = new ChangeLogBuilder($repo, new \ArtARTs36\GitHandler\DocBuilder\StubLoader($files), $files);

$builder->build(__DIR__ . '/../../CHANGELOG.MD');
