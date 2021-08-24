<?php

use ArtARTs36\GitHandler\Factory\LocalGitFactory;

require_once 'vendor/autoload.php';

$git = (new LocalGitFactory())->factory(__DIR__ . '/../../');

// execute build

require_once 'build.php';

if ($git->statuses()->status(true)->isNotEmpty()) {
    echo "Documentation is not actually";
    exit(1);
}

echo "OK";

exit(0);
