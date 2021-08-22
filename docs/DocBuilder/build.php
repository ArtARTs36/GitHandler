<?php

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\DocBuilder\DocBuilder;
use ArtARTs36\GitHandler\DocBuilder\HomePageBuilder;
use ArtARTs36\GitHandler\DocBuilder\StubLoader;
use ArtARTs36\GitHandler\Support\LocalFileSystem;

require_once __DIR__ . '/../../vendor/autoload.php';

//

function snake_case(string $input): string
{
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

//

$fileSystem = new LocalFileSystem();
$stubLoader = new StubLoader($fileSystem);

$docBuilder = new DocBuilder(
    $rootReflector = new \ReflectionClass(GitHandler::class),
    $stubLoader
);

$homePageBuilder = new HomePageBuilder($stubLoader);

$pages = $docBuilder->build();

foreach ($pages as $page) {
    $fileSystem->createFile(__DIR__ . '/../' . $page->file, $page->content);
}

$fileSystem->createFile(__DIR__ . '/../../readme.md', $homePageBuilder->build($pages));
