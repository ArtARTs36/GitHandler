<?php

namespace ArtARTs36\GitHandler\Support;

class HookName
{
    use Enumerable;

    public const APPLY_PATH_MSG = 'applypatch-msg'; // git am
    public const POST_UPDATE = 'post-update'; // git push: after push
    public const PRE_COMMIT = 'pre-commit'; // git commit: before commit
}
