<?php

namespace ArtARTs36\GitHandler\Support;

class HookName
{
    use Enumerable;

    public const APPLY_PATH_MSG = 'applypatch-msg'; // git am
    public const COMMIT_MSG = 'commit-msg';
    public const FS_MONITOR_WATCHMAN = 'fsmonitor-watchman';
    public const PRE_APPLY_PATCH = 'pre-applypatch';
    public const PRE_COMMIT = 'pre-commit'; // git commit: before commit
    public const PREPARE_COMMIT_MSG = 'prepare-commit-msg';
    public const PRE_PUSH = 'pre-push'; // git push: before push
    public const PRE_REBASE = 'pre-rebase';
    public const POST_UPDATE = 'post-update'; // git push: after push
    public const PRE_RECEIVE = 'pre-receive';
    public const UPDATE = 'update';
}
