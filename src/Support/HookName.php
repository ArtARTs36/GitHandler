<?php

namespace ArtARTs36\GitHandler\Support;

class HookName
{
    use Enumerable;

    public const APPLY_PATH_MSG_SAMPLE = 'applypatch-msg.sample'; // git am
    public const POST_UPDATE_SAMPLE = 'post-update.sample'; // git push: after push
    public const PRE_COMMIT_SAMPLE = 'pre-commit.sample'; // git commit: before commit
}
