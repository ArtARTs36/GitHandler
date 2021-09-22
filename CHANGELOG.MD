## ChangeLog

[View all Releases](https://github.com/ArtARTs36/GitHandler/releases)

# 0.1.0 :: Initial release

[View Changes](https://github.com/ArtARTs36/GitHandler/releases/tag/0.1.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.1.0)

Initial release with features:
* [Wrap: Git Pull](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L41)
* [Wrap: Git Init](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L64)
* [Wrap: Git Checkout](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L81)
* [Wrap: Git Status](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L97)
* [Wrap: Git Add](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L112)
* [Wrap: Git Clone](https://github.com/ArtARTs36/GitHandler/blob/b11a5d7a32af9c4a28b753be3c82bb181158e968/src/Git.php#L132)
# 0.2.0 :: Add new features

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.1.0...0.2.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.0)

#### Added

* [Git Stash](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Git.php#L153)
* [Delete repository Action](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Action.php#L66)
# 0.2.1 :: Git clone support target folder

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.0...0.2.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.1)

#### Changed

* [Git clone support target folder](https://github.com/ArtARTs36/GitHandler/blob/200bd4af390018c89478411d23d15e6c2fd60a8e/src/Git.php#L133)
# 0.2.2 :: Show remote

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.1...0.2.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.2)

#### Added

* [Reinstall: Delete local repository and fetch from origin](https://github.com/ArtARTs36/GitHandler/blob/0.2.2/src/Action.php#L66)
* [Show remote](https://github.com/ArtARTs36/GitHandler/blob/1cb415c78cf0693b4d6a7ebd098212abce57d1c7/src/Git.php#L204)
# 0.2.3 :: Fix FileSystem for non-existing paths

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.2...0.2.3)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.3)

#### Fixed
* [Fix FileSystem for non-existing paths](https://github.com/ArtARTs36/GitHandler/commit/36a5fb17fff70d3452d3ad8f6941181c72df715c)

# 0.3.0 :: Add Contracts

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.3...0.3.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.0)


#### Added
* [Add .gitattributes](https://github.com/ArtARTs36/GitHandler/commit/a4654767203f8bea56f09f38f95cda2a414c56d5)
* Add Contracts: GitHandler, Taggable, Addable, HasRemotes, Pushable
* [Wrap git remote add](https://github.com/ArtARTs36/GitHandler/compare/0.2.3...0.3.0#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R202)
* Remove internal Str helper
* [Add Exception "TagAlreadyExist"](https://github.com/ArtARTs36/GitHandler/blob/03a074ea0b4b255c243d4226dd45ae6dea2265b5/src/Exceptions/TagAlreadyExist.php)
* [Add Data Object "Remotes"](https://github.com/ArtARTs36/GitHandler/blob/03a074ea0b4b255c243d4226dd45ae6dea2265b5/src/Data/Remotes.php)

# 0.3.1 :: Logable

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.0...0.3.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.1)


# fetch && commit amend

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.1...0.3.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.2)


# Read && Save Config

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.2...0.4.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.4.0)


# 0.5.0 :: Refactor File System

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.4.0...0.5.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.5.0)


# 0.6.0 :: Has Paths and unstash

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.5.0...0.6.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.6.0)


# 0.7.0 :: use str wrapper in contracts

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.6.0...0.7.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.7.0)


# 0.8.0 :: Repository downloader

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.7.0...0.8.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.8.0)


# 0.8.1 :: Support download from bitbucket.org

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.8.0...0.8.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.8.1)


# 0.9.0 :: HasRemotes :: remove remote

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.8.1...0.9.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.9.0)


# 0.10.0 :: Docs And New Features

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.10.0)


# 0.10.1 :: throw BranchDoesNotHaveCommits

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.10.0...0.10.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.10.1)


# 0.11.0 :: Git grep

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.10.1...0.11.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.0)

* Git grep
* Mutation Testing
# 0.11.1 :: OriginUrl::toRepo

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.0...0.11.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.1)


# 0.11.2 :: OriginUrlSelector::selectByUrl

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.1...0.11.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.2)

* OriginUrlSelector::selectByUrl
# 0.12.0 :: Add new features

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.12.0)


# 0.12.1 :: fix Git::add at many files

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.12.0...0.12.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.12.1)


# 0.13.0 :: Add branch config && remove webmozart/assert

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.12.1...0.13.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.13.0)


# 1.0.0 :: New Major Version

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.13.0...1.0.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/1.0.0)

## Features
* Manage git attributes
* Merge Commands
* Garbage Commands
* Archive Commands
* Git Index Commands
* Add support git on remote server
* Execute operations through transactions
* Rollback command
* Git Version - full information

## Fixes
* Correct processing of command results 

## Backward Incompatible Changes
* This version is not backward compatible with 0.x
* See new readme

## Internal
* Build documentation by php interfaces (starts with GitHandler)
