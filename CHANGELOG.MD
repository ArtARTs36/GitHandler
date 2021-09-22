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

### Added

* [Git Stash](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Git.php#L153)
* [Delete repository Action](https://github.com/ArtARTs36/GitHandler/blob/b765c99cea137625a8b7a0de97d6df434cd8d480/src/Action.php#L66)
# 0.2.1 :: Git clone support target folder

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.0...0.2.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.1)

### Changed

* [Git clone support target folder](https://github.com/ArtARTs36/GitHandler/blob/200bd4af390018c89478411d23d15e6c2fd60a8e/src/Git.php#L133)
# 0.2.2 :: Show remote

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.1...0.2.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.2)

### Added

* [Reinstall: Delete local repository and fetch from origin](https://github.com/ArtARTs36/GitHandler/blob/0.2.2/src/Action.php#L66)
* [Show remote](https://github.com/ArtARTs36/GitHandler/blob/1cb415c78cf0693b4d6a7ebd098212abce57d1c7/src/Git.php#L204)
# 0.2.3 :: Fix FileSystem for non-existing paths

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.2...0.2.3)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.2.3)

### Fixed
* [Fix FileSystem for non-existing paths](https://github.com/ArtARTs36/GitHandler/commit/36a5fb17fff70d3452d3ad8f6941181c72df715c)

# 0.3.0 :: Add Contracts

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.2.3...0.3.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.0)

### Added
* [Add .gitattributes](https://github.com/ArtARTs36/GitHandler/commit/a4654767203f8bea56f09f38f95cda2a414c56d5)
* Add Contracts: GitHandler, Taggable, Addable, HasRemotes, Pushable
* [Wrap git remote add](https://github.com/ArtARTs36/GitHandler/compare/0.2.3...0.3.0#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R202)
* Remove internal Str helper
* [Add Exception "TagAlreadyExist"](https://github.com/ArtARTs36/GitHandler/blob/03a074ea0b4b255c243d4226dd45ae6dea2265b5/src/Exceptions/TagAlreadyExist.php)
* [Add Data Object "Remotes"](https://github.com/ArtARTs36/GitHandler/blob/03a074ea0b4b255c243d4226dd45ae6dea2265b5/src/Data/Remotes.php)

# 0.3.1 :: Logable

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.0...0.3.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.1)

### Added
* [Contract "Initable"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Contracts/Initable.php)
* [Contract "Logable"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Contracts/Logable.php)
* [Data Object "Author"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Data/Author.php)
* [Data Object "Log"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Data/Log.php)
* [Log Collection](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Data/LogCollection.php)
* [Exception "Nothing to Commit"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Exceptions/NothingToCommit.php) - throws in "git commit"
* [Exception "Repository Already Exists"](https://github.com/ArtARTs36/GitHandler/blob/f0cdbe421e82304343609b20ba2cccbedb0694e2/src/Exceptions/epositoryAlreadyExists.php) - throws in "git clone"
* [Wrap: Git Commit](https://github.com/ArtARTs36/GitHandler/compare/0.3.0...0.3.1#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R250)
* [Wrap: Git Log](https://github.com/ArtARTs36/GitHandler/compare/0.3.0...0.3.1#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R279)
# 0.3.2 :: Fetch && commit amend

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.1...0.3.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.3.2)

### Added
* [Wrap: Git Fetch](https://github.com/ArtARTs36/GitHandler/compare/0.3.1...0.3.2#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R296)

### Changed
* [Git Commit supported amend mode](https://github.com/ArtARTs36/GitHandler/compare/0.3.1...0.3.2#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R252)

### Internal
* [Create interface "LogParser" for read input git response](https://github.com/ArtARTs36/GitHandler/blob/7b10e5420bcf3e431a1a8dfb3a8f9a60fc4020e1/src/Contracts/LogParser.php)
# 0.4.0 :: Read && Save Config

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.3.2...0.4.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.4.0)

### Added
* [Factory for simple repositories](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/GitSimpleFactory.php)
* [Contract "Configurable"](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/Contracts/Configurable.php)
Read config available for subjects:
* [Core](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/Config/Subjects/Core.php)
* [Credential](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/Config/Subjects/Credential.php)
* [Pack](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/Config/Subjects/Pack.php)
* [User](https://github.com/ArtARTs36/GitHandler/blob/429b6a57df086e5428bb80449a7a891c99ce73e2/src/Config/Subjects/User.php)
# 0.5.0 :: Refactor File System

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.4.0...0.5.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.5.0)

### Changed
* [Call file system through FileSystem Contract](https://github.com/ArtARTs36/GitHandler/blob/a5e1e60adc3981ca524fa095e1996e4bf724f920/src/Contracts/FileSystem.php)
* [Add Exception "BranchHasNoUpstream"](https://github.com/ArtARTs36/GitHandler/blob/a5e1e60adc3981ca524fa095e1996e4bf724f920/src/Exceptions/BranchHasNoUpstream.php)
* [All exceptions extends "GitHandlerException"](https://github.com/ArtARTs36/GitHandler/blob/a5e1e60adc3981ca524fa095e1996e4bf724f920/src/Exceptions/GitHandlerException.php)

### Internal
* Improved test coverage
# 0.6.0 :: Has Paths and unstash

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.5.0...0.6.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.6.0)

### Added
* [Contract "HasPaths"](https://github.com/ArtARTs36/GitHandler/blob/5113cfc1f28af67324a53645c34df2b876f32957/src/Contracts/HasPaths.php) for get git path(info, html, man)
* [Contract "Stashable"](https://github.com/ArtARTs36/GitHandler/blob/5113cfc1f28af67324a53645c34df2b876f32957/src/Contracts/Stashable.php)
* [Contract "Statusable"](https://github.com/ArtARTs36/GitHandler/blob/5113cfc1f28af67324a53645c34df2b876f32957/src/Contracts/Statusable.php)
* [Contract "Versionable"](https://github.com/ArtARTs36/GitHandler/blob/5113cfc1f28af67324a53645c34df2b876f32957/src/Contracts/Versionable.php)
* [Wrap git help](https://github.com/ArtARTs36/GitHandler/compare/0.5.0...0.6.0#diff-64458c015b326c5ca1410ef1e3f9daed5381710fbd5460108dc635db17f00995R51)

### Changed
* [ConfiguratorsDict implements IteratorAggregate](https://github.com/ArtARTs36/GitHandler/compare/0.5.0...0.6.0#diff-545b34f6064c6c8e256654e61247aae25617c9a115b885dc906bb87fd97ef311R8)
# 0.7.0 :: use str wrapper in contracts

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.6.0...0.7.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.7.0)

### Added
* [GitHandler::getUntrackedFiles](https://github.com/ArtARTs36/GitHandler/compare/0.6.0...0.7.0#diff-20d14f8d1c07cebbf713ca704c55b1c6e0de9b23dbd2db5a722ca9cd37275517R19)
* [GitHandler::getModifiedFiles](https://github.com/ArtARTs36/GitHandler/compare/0.6.0...0.7.0#diff-20d14f8d1c07cebbf713ca704c55b1c6e0de9b23dbd2db5a722ca9cd37275517R24)
* [GitHandler::getAddedFiles](https://github.com/ArtARTs36/GitHandler/compare/0.6.0...0.7.0#diff-20d14f8d1c07cebbf713ca704c55b1c6e0de9b23dbd2db5a722ca9cd37275517R29)
# 0.8.0 :: Repository downloader

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.7.0...0.8.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.8.0)

### Added
* [OriginUrl for make url to remote](https://github.com/ArtARTs36/GitHandler/compare/0.7.0...0.8.0#diff-cbbfa44686443e3be36b0aa795742b6b1c17c1384c0064857f897765952c8430R5) - implements: GitHub, GitLab
* [Exception "OriginUrlNotFound"](https://github.com/ArtARTs36/GitHandler/compare/0.7.0...0.8.0#diff-f80ee1a5e85513f0ca2c6c6e1b838c4c20b510e8c7e7ec083f929a2fa2b521c1R5)
* [RepositoryDownloader for download repository from origin](https://github.com/ArtARTs36/GitHandler/compare/0.7.0...0.8.0#diff-8ddf40a9f1da55517939c189839eea20ce83fd6cfe68a4f504719bbade9f2818R11)
# 0.8.1 :: Support download from bitbucket.org

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.8.0...0.8.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.8.1)

### Added
* Implements BitBucket for Contract "OriginUrl"
# 0.9.0 :: HasRemotes :: remove remote

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.8.1...0.9.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.9.0)

### Added
* [Wrap: "git remote remove"](https://github.com/ArtARTs36/GitHandler/compare/0.8.1...0.9.0#diff-c04818367c2a20af2d664a0c65ddaa19c80445c94f9b24428d3148ac7e094a2cR24)
* [Exception "RemoteAlreadyExists"](https://github.com/ArtARTs36/GitHandler/blob/e29b3e2feb04e18ee01f07fdd0aee6d0ba568d95/src/Exceptions/RemoteAlreadyExists.php)
* [Exception "RemoteNotFound"](https://github.com/ArtARTs36/GitHandler/blob/e29b3e2feb04e18ee01f07fdd0aee6d0ba568d95/src/Exceptions/RemoteNotFound.php)
# 0.10.0 :: Docs And New Features

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.10.0)

### Added
* [Contract "Checkoutable"](https://github.com/ArtARTs36/GitHandler/blob/070041e529f130e598a2b506decaf8d76626c836/src/Contracts/Checkoutable.php)
* [Contract "Fetchable" with methods: "fetch", "fetchAll"](https://github.com/ArtARTs36/GitHandler/blob/070041e529f130e598a2b506decaf8d76626c836/src/Contracts/Fetchable.php)
* [ConfigSubject::isEmpty](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0#diff-aa5e413674a52b8a684b08a8a41c6fd68d69cab7a7a02d50d5b944e2d9692c01R12)
* [Interacts with .gitignore](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0#diff-47bb94f70c74ab3c39a6ef098941441f2235eba5436699ba25b530e0bf1b5b9eR9)

### Changed
* ["git add" supports force mode](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0#diff-766bd3c5123c64b832e2be880d2af016e59b0f3dd608abd0f896837cd1a8c8a5R10)
* ["git push" supports force mode](https://github.com/ArtARTs36/GitHandler/compare/0.9.0...0.10.0#diff-c87d57128b19420ea96c1f5238ed856224c1d8b75dbab288fc3de8da3caf90b5R13)
# 0.10.1 :: Interacts with git branches

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.10.0...0.10.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.10.1)

### Added
* [Wrap "git branch -d"](https://github.com/ArtARTs36/GitHandler/compare/0.10.0...0.10.1#diff-91525d39f3c6475f6653bfe723e3516e3e8a26daaeeff2c9b0869ca8b1a8d2daR15)
* [Wrap "git branch"](https://github.com/ArtARTs36/GitHandler/compare/0.10.0...0.10.1#diff-91525d39f3c6475f6653bfe723e3516e3e8a26daaeeff2c9b0869ca8b1a8d2daR17)
* [Wrap "git branch -a"](https://github.com/ArtARTs36/GitHandler/compare/0.10.0...0.10.1#diff-91525d39f3c6475f6653bfe723e3516e3e8a26daaeeff2c9b0869ca8b1a8d2daR22)
* [Exception "BranchAlreadyExists"](https://github.com/ArtARTs36/GitHandler/blob/a6fc1990b565f92efd00b25dc7af862565d48240/src/Exceptions/BranchAlreadyExists.php)
* [Exception "BranchDoesNotHaveCommits"](https://github.com/ArtARTs36/GitHandler/blob/a6fc1990b565f92efd00b25dc7af862565d48240/src/Exceptions/BranchDoesNotHaveCommits.php)
# 0.11.0 :: Git grep

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.10.1...0.11.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.0)

### Added
* [Wrap: Git Grep](https://github.com/ArtARTs36/GitHandler/compare/0.10.1...0.11.0#diff-1d57d7cd19da40c2859b6b100b353996b3de84ca8e6fcb39931d59332c46c906R7)

### Internal
* [Add Mutation Testing to Github Actions](https://github.com/ArtARTs36/GitHandler/blob/11c16c97b27bfb8e8142c6c31da715acdad2b003/infection.json.dist)
* [Add LICENSE file](https://github.com/ArtARTs36/GitHandler/blob/11c16c97b27bfb8e8142c6c31da715acdad2b003/LICENSE)
# 0.11.1 :: OriginUrl::toRepoFromUrl

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.0...0.11.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.1)

### Added
* [Data Object "Repo"](https://github.com/ArtARTs36/GitHandler/blob/044d40bc05a31508631ca21fda55a3207424b1eb/src/Data/Repo.php)
* [Converter to "Repo"](https://github.com/ArtARTs36/GitHandler/compare/0.11.0...0.11.1#diff-cbbfa44686443e3be36b0aa795742b6b1c17c1384c0064857f897765952c8430R22)
# 0.11.2 :: OriginUrlSelector::selectByUrl

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.1...0.11.2)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.11.2)

* OriginUrlSelector::selectByUrl
# 0.12.0 :: Add new features

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.12.0)

### Added
* [Wrap: git switch <branch-name>](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-91525d39f3c6475f6653bfe723e3516e3e8a26daaeeff2c9b0869ca8b1a8d2daR25)
* [Wrap: git branch --show-current](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-91525d39f3c6475f6653bfe723e3516e3e8a26daaeeff2c9b0869ca8b1a8d2daR30)
* [Wrap: git stash list](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-d1ddccf832a79155c10ceeeef5ca2e13c2d124c707271eb7d7f151acde0b9be8R16)
* [Wrap: git stash apply stash@{1}](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-d1ddccf832a79155c10ceeeef5ca2e13c2d124c707271eb7d7f151acde0b9be8R18)
* [Git autoCommit](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R181) - (git add modified files & commit)
* [GitHandler::addHook](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-4d3833c53107580846e4eb068bbb3e31853418f51a8bfa8d789761e2990a91fcR12)
* [GitHandler::hasHook](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-4d3833c53107580846e4eb068bbb3e31853418f51a8bfa8d789761e2990a91fcR17)
* [GitHandler::deleteHook](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-4d3833c53107580846e4eb068bbb3e31853418f51a8bfa8d789761e2990a91fcR23)
* [GitHandler::getHook](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-4d3833c53107580846e4eb068bbb3e31853418f51a8bfa8d789761e2990a91fcR29)
* [GitHandler::getHooks](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-4d3833c53107580846e4eb068bbb3e31853418f51a8bfa8d789761e2990a91fcR34)
* [GitHandler::pushOnAutoSetUpStream](https://github.com/ArtARTs36/GitHandler/compare/0.11.2...0.12.0#diff-c87d57128b19420ea96c1f5238ed856224c1d8b75dbab288fc3de8da3caf90b5R18)

# 0.12.1 :: fix Git::add at many files

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.12.0...0.12.1)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.12.1)

### Fixed
* [GitHandler::add at many files](https://github.com/ArtARTs36/GitHandler/compare/0.12.0...0.12.1#diff-e6c1b6b7de0fe4a3e42ac15ab80c7b0758fc604d1ad24384c82c65a84c998a06R103)
# 0.13.0 :: Add branch config && remove webmozart/assert

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.12.1...0.13.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/0.13.0)


# 1.0.0 :: New Major Version

[View Changes](https://github.com/ArtARTs36/GitHandler/compare/0.13.0...1.0.0)

[View on Github](https://github.com/ArtARTs36/GitHandler/releases/tag/1.0.0)

### Added
* Manage git attributes
* Merge Commands
* Garbage Commands
* Archive Commands
* Git Index Commands
* Add support git on remote server
* Execute operations through transactions
* Rollback command
* Git Version - full information

### Fixed
* Correct processing of command results 

### Backward Incompatible Changes
* This version is not backward compatible with 0.x
* See new readme

### Internal
* Build documentation by php interfaces (starts with GitHandler)
