<?php

namespace ArtARTs36\GitHandler\Support;

/**
 * @link https://git-scm.com/docs/pretty-formats
 */
class FormatPlaceholder
{
    public const COMMIT_HASH = '%H';
    public const BODY = '%b';

    public const SUBJECT = '%s';

    public const REF_NAME = '%d'; // ref names, like the --decorate option of git-log(1)

    public const REFLOG_SUBJECT = '%gs';
    public const REFLOG_SELECTOR = '%gD'; // reflog selector, e.g., refs/stash@{1}
    public const REFLOG_SHORTENED_SELECTOR = '%gd'; // shortened reflog selector, e.g., stash@{1}

    public const AUTHOR_NAME = '%an';
    public const AUTHOR_EMAIL = '%ae';

    public const AUTHOR_DATE_RFC2822 = '%aD';

    public const NEW_LINE = '%n';

    public const TREE_HASH = '%T';
    public const TREE_ABBREVIATED_HASH = '%t';

    /**
     * @codeCoverageIgnore
     */
    public static function format(array $holders, string $separator = '|'): string
    {
        return "format:'" . implode($separator, $holders) . "'";
    }
}
