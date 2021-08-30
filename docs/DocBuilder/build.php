<?php

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\DocBuilder\ClassFinder;
use ArtARTs36\GitHandler\DocBuilder\DevelopmentCommandsTableBuilder;
use ArtARTs36\GitHandler\DocBuilder\DocBuilder;
use ArtARTs36\GitHandler\DocBuilder\DocCommandPageBuilder;
use ArtARTs36\GitHandler\DocBuilder\HomePageBuilder;
use ArtARTs36\GitHandler\DocBuilder\Page;
use ArtARTs36\GitHandler\DocBuilder\Project;
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

$start = microtime(true);

//

$project = new Project(realpath(__DIR__ . '/../..'));

ClassFinder::setProjectDir($project->getRootDir());

$fileSystem = new LocalFileSystem();
$stubLoader = new StubLoader($fileSystem);

$docBuilder = new DocBuilder(
    $rootReflector = new \ReflectionClass(GitHandler::class),
    $stubLoader,
    new DocCommandPageBuilder($stubLoader, $project)
);

$homePageBuilder = new HomePageBuilder($stubLoader, new DevelopmentCommandsTableBuilder($project));

$pages = $docBuilder->build();

usort($pages, function (Page $one, Page $two) {
    return $one->title <=> $two->title;
});

foreach ($pages as $page) {
    $fileSystem->createFile(__DIR__ . '/../' . $page->file, $page->content);
}

$fileSystem->createFile(__DIR__ . '/../../readme.md', $homePageBuilder->build($pages));

echo "Generation Time: ". (microtime(true) - $start);
