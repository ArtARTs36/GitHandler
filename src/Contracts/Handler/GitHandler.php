<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand;
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
use ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitSetupCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPathCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPullCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStashCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitStatusCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitTagCommand;
use ArtARTs36\GitHandler\Contracts\Commands\HasSubmodules;
use ArtARTs36\GitHandler\Contracts\HasContext;
use ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction;

interface GitHandler extends Versionable, HasRemotes, HasAttributes, HasSubmodules, HasBackup, HasContext
{
    /**
     * Git Help
     */
    public function helps(): GitHelpCommand;

    /**
     * Git Paths
     */
    public function paths(): GitPathCommand;

    /**
     * Git Tags
     */
    public function tags(): GitTagCommand;

    /**
     * Git Hooks
     */
    public function hooks(): GitHookCommand;

    /**
     * Git Archives
     */
    public function archives(): GitArchiveCommand;

    /**
     * Git Logs
     */
    public function logs(): GitLogCommand;

    /**
     * Git Greps
     */
    public function greps(): GitGrepCommand;

    /**
     * Git Setup
     */
    public function setup(): GitSetupCommand;

    /**
     * Git Branches
     */
    public function branches(): GitBranchCommand;

    /**
     * Git Files
     */
    public function files(): GitFileCommand;

    /**
     * Git Index
     */
    public function index(): GitIndexCommand;

    /**
     * Git Pushes
     */
    public function pushes(): GitPushCommand;

    /**
     * Git Statuses
     */
    public function statuses(): GitStatusCommand;

    /**
     * Git Commits
     */
    public function commits(): GitCommitCommand;

    /**
     * Git Stashes
     */
    public function stashes(): GitStashCommand;

    /**
     * Git Config
     */
    public function config(): GitConfigCommand;

    /**
     * Git Ignore
     */
    public function ignores(): GitIgnoreCommand;

    /**
     * Git Pulls
     */
    public function pulls(): GitPullCommand;

    /**
     * Git Transaction
     */
    public function transaction(): GitTransaction;

    /**
     * Git Garbage collect
     */
    public function garbage(): GitGarbageCommand;

    /**
     * Git Merges
     */
    public function merges(): GitMergeCommand;

    /**
     * Git fetches
     */
    public function fetches(): GitFetchCommand;
}
