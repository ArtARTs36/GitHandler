<?php

use ArtARTs36\GitHandler\Factory\LocalGitFactory;

require_once 'vendor/autoload.php';

$git = (new LocalGitFactory())->factory(__DIR__ . '/../../');

// execute build

$statusBeforeDocBuild = $git->statuses()->status(true);

require_once 'build.php';

$file = $git->statuses()->getModifiedFiles()[0];

var_dump(file_get_contents($file));

if ($git->statuses()->status(true)->equals($statusBeforeDocBuild)) {
    echo "OK\n";
    exit(0);
}

echo "Documentation is not actually\n";
exit(1);
