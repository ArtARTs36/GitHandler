## Git Handler

![PHP Composer](https://github.com/ArtARTs36/GitHandler/workflows/PHP%20Composer/badge.svg?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://poser.pugx.org/artarts36/git-handler/d/total.svg">
    <img src="https://poser.pugx.org/artarts36/git-handler/d/total.svg" alt="Total Downloads">
</a>
[![Infection MSI](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FArtARTs36%2FGitHandler%2Fmaster)](https://infection.github.io)

----

## Description:

Tool for work with Git in PHP

---

## Installation:

`composer require artarts36/git-handler`

----

## Features

* [Git Archive](docs/git_archive_command.md)
* [Git Attributes](docs/git_attribute_command.md)
* [Git Branches](docs/git_branch_command.md)
* [Git Commits](docs/git_commit_command.md)
* [Git Config (set, get list, ...)](docs/git_config_command.md)
* [Git Files](docs/git_file_command.md)
* [Git Garbage Collector](docs/git_garbage_command.md)
* [Git Grep](docs/git_grep_command.md)
* [Git Help](docs/git_help_command.md)
* [Git Hooks](docs/git_hook_command.md)
* [Git Ignore Files (.gitignore)](docs/git_ignore_command.md)
* [Git Index: (git add, git reset, git rm, ...)](docs/git_index_command.md)
* [Git Init](docs/git_setup_command.md)
* [Git Log](docs/git_log_command.md)
* [Git Merge](docs/git_merge_command.md)
* [Git Paths (info-path, html-path, man-path, ...)](docs/git_path_command.md)
* [Git Pull](docs/git_pull_command.md)
* [Git Push](docs/git_push_command.md)
* [Git Remote (add, show, remove, ...)](docs/git_remote_command.md)
* [Git Stash](docs/git_stash_command.md)
* [Git Status](docs/git_status_command.md)
* [Git Tags](docs/git_tag_command.md)
* [Git Transactions](docs/git_transaction.md)
* [Download](docs/downloader.md)

----

## Extensions
* [artarts36/git-handler-remote](https://github.com/ArtARTs36/php-git-handler-remote) - Work with git repository on remote server

----

## Development

|  Command  | Description  |
| ------------ | ------------ |
|  composer lint    |    Check code on PSR
|  composer stat-analyse    |    Run stat analyse
|  composer test    |    Run tests
|  composer mutate-test    |    Run mutation testing
|  composer build-docs    |    Build documentation
|  composer check-docs-actual    |    Check Documentation is actually
|  composer build-changelog    |    Build CHANGELOG.MD
