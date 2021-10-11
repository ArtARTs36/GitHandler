<?php

use ArtARTs36\GitHandler\DocBuilder\StubLoader;
use ArtARTs36\GitHandler\DocBuilder\TopContributorsBuilder;
use ArtARTs36\GitHandler\Factory\LocalGitFactory;
use ArtARTs36\FileSystem\Local\LocalFileSystem;

require_once __DIR__ . '/../../vendor/autoload.php';

$git = (new LocalGitFactory())->factory(__DIR__ . '/../../');

$fileSystem = new LocalFileSystem();
$stubLoader = new StubLoader($fileSystem);

$fileSystem->createFile(__DIR__ . '/../../CONTRIBUTORS.MD', (new TopContributorsBuilder($stubLoader))->build($git));
