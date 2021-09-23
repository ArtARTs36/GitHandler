<?php

use ArtARTs36\GitHandler\DocBuilder\ChangeLogBuilder;
use ArtARTs36\GitHandler\DocBuilder\GithubRepo;
use ArtARTs36\GitHandler\DocBuilder\StubLoader;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\GitHandler\Support\LocalFileSystem;
use GuzzleHttp\Client;

require_once __DIR__ . '/../../vendor/autoload.php';

$urlBuilder = new GithubOriginUrlBuilder();

$repoData = $urlBuilder->toRepoFromUrl('https://github.com/ArtARTs36/GitHandler');

$repo = new GithubRepo(new Client(), 'api.github.com', $repoData, getenv('GITHUB_API_TOKEN'));

$files = new LocalFileSystem();

$builder = new ChangeLogBuilder($repo, new StubLoader($files), $files);

$builder->build(__DIR__ . '/../../CHANGELOG.MD');
