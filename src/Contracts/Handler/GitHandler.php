<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Command\Commands\Contracts\GitArchiveCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitBranchCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitCommitCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitConfigCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitFileCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitGrepCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitHelpCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitHookCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitIgnoreCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitSetupCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitLogCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPathCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPullCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitPushCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitStashCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitStatusCommand;
use ArtARTs36\GitHandler\Command\Commands\Contracts\GitTagCommand;

interface GitHandler extends Versionable, HasRemotes
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
}
