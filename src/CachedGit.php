<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitBranchCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitCommitCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitFetchCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitFileCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitGarbageCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitGrepCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitHelpCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitHookCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIgnoreCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPathCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPullCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSetupCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStashCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStatusCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitTagCommand;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction;
use ArtARTs36\GitHandler\Data\Version;

class CachedGit implements GitHandler
{
    private $git;

    /** @var array<string, object> */
    private $cache = [];

    public function __construct(GitHandler $git)
    {
        $this->git = $git;
    }

    public function helps(): GitHelpCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function paths(): GitPathCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function tags(): GitTagCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function hooks(): GitHookCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function archives(): GitArchiveCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function logs(): GitLogCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function greps(): GitGrepCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function setup(): GitSetupCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function branches(): GitBranchCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function files(): GitFileCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function index(): GitIndexCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function pushes(): GitPushCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function statuses(): GitStatusCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function commits(): GitCommitCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function stashes(): GitStashCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function config(): GitConfigCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function ignores(): GitIgnoreCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function pulls(): GitPullCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function transaction(): GitTransaction
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function garbage(): GitGarbageCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function merges(): GitMergeCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function attributes(): GitAttributeCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function remotes(): GitRemoteCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function version(): Version
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function backup(): GitBackup
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function submodules(): GitSubmoduleCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    public function fetches(): GitFetchCommand
    {
        return $this->cachedAndReturn(__FUNCTION__);
    }

    /**
     * @return mixed|object
     */
    protected function cachedAndReturn(string $rootMethodName)
    {
        if (! array_key_exists($rootMethodName, $this->cache)) {
            $this->cache[$rootMethodName] = $this->git->$rootMethodName();
        }

        return $this->cache[$rootMethodName];
    }
}
