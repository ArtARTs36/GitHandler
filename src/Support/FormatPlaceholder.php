<?php

namespace ArtARTs36\GitHandler\Support;

class FormatPlaceholder
{
    public const BODY = '%b';

    public const SUBJECT = '%s';

    public const REF_NAME = '%d'; // ref names, like the --decorate option of git-log(1)

    public const REFLOG_SUBJECT = '%gs';
    public const REFLOG_SELECTOR = '%gD'; // reflog selector, e.g., refs/stash@{1}
    public const REFLOG_SHORTENED_SELECTOR = '%gd'; // shortened reflog selector, e.g., stash@{1}

    /**
     * @codeCoverageIgnore
     */
    public static function format(array $holders, string $separator = '|'): string
    {
        return "format:'" . implode($separator, $holders) . "'";
    }
}
