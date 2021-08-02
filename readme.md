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

## Simple create an Instance

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
```

----

## Get Help Information:

#### -> git --help

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->help());
```

---

## Get Git Version

#### -> git version

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->version());
```

---

## Init Operations

[About git init](https://git-scm.com/docs/git-init)

Use the Interface: [\ArtARTs36\GitHandler\Contracts\Initable](./src/Contracts/Initable.php)

#### * Check if the repository is initialized :

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->isInit());
```

#### -> git init:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->init();
```

---

## Repository actions

#### * Create folder in repository:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$action = \ArtARTs36\GitHandler\GitSimpleFactory::factoryRepository($git)

$action->createFolder('folder_name');
```

#### * Create file in repository:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$action = \ArtARTs36\GitHandler\GitSimpleFactory::factoryRepository($git)

$action->createFile('file.php', 'echo hello world');
$action->createFile('file.php', 'echo hello world', 'folder_name');
```

#### * Delete repository:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$action = \ArtARTs36\GitHandler\GitSimpleFactory::factoryRepository($git)

$action->delete();
```

#### * Reinstall repository (Delete local repository and fetch from origin):

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$action = \ArtARTs36\GitHandler\GitSimpleFactory::factoryRepository($git)

$action->reinstall();
```

---

## Branch Operations

[About git branch](https://git-scm.com/docs/git-branch)

Use the interface: [ArtARTs36\GitHandler\Contracts\HasBranches](./src/Contracts/HasBranches.php)

#### -> git checkout <branch-name>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->checkout('branch-name');
```

#### -> git checkout <branch-name> --merge:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->checkout('branch-name', true);
```

#### -> git switch <branch-name>

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->switchBranch('branch-name');
```

---

#### -> git branch -d <branch-name>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->deleteBranch('branch-name');
```

---

#### -> git branch -a:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getBranches());
```

---

#### -> git branch --show-current:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getCurrentBranch());
```

---

## Grep Operations

[About git-grep](https://git-scm.com/docs/git-grep)

Use the interface: [ArtARTs36\GitHandler\Contracts\Grepable](./src/Contracts/Grepable.php)

#### -> git --no-pager grep -n <term>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$matches = $git->grep('term');

foreach ($matches as $match) {
    var_dump($match->file);
    var_dump($match->line);
    var_dump($match->content);
}
```

---

## Push Operations

[About git push](https://git-scm.com/docs/git-push)

Use the interface: [ArtARTs36\GitHandler\Contracts\Pushable](./src/Contracts/Pushable.php)

#### -> git push

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->push();
```

#### -> git push --force

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->push(true);
```

#### -> git push --set-upstream origin

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->pushOnAutoSetUpStream(true);
```

---

## Fetch Operations

[About git fetch](https://git-scm.com/docs/git-fetch)

Use the interface: [\ArtARTs36\GitHandler\Contracts\Fetchable](./src/Contracts/Fetchable.php)

#### -> git fetch:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->fetch();
```

#### -> git fetch --all:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->fetchAll();
```

---

## Clone Operations

[About git clone](https://git-scm.com/docs/git-clone)

#### -> git clone:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->clone('https://github.com/ArtARTs36/GitHandler');
```

#### -> git clone \<branch\>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->clone('https://github.com/ArtARTs36/GitHandler', 'branch');
```

#### -> git clone \<branch\> \<folder\>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->clone('https://github.com/ArtARTs36/GitHandler', 'branch', 'folder');
```

---

## Add Operations

[About git add](https://git-scm.com/docs/git-add)

Use the interface: [\ArtARTs36\GitHandler\Contracts\Addable](./src/Contracts/Addable.php)

---

#### -> git add <file_name>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->add('file_name');
```

#### -> git add <file_name_1> <file_name_2> <file_name_3>:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->add(['file_name_1', 'file_name_2', 'file_name_3']);
```

#### -> git add <file_name> --force:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->add('file_name', true));
```

---

## Logging

[About git log](https://git-scm.com/docs/git-log)

Use the interface: [\ArtARTs36\GitHandler\Contracts\Logable](./src/Contracts/Logable.php)

---

Data Objects:

* [\ArtARTs36\GitHandler\Data\Author](./src/Data/Author.php)
* [\ArtARTs36\GitHandler\Data\Log](./src/Data/Log.php)
* [\ArtARTs36\GitHandler\Data\LogCollection](./src/Data/LogCollection.php)<[Log](./src/Data/Log.php)>

---

#### -> git log:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

foreach ($git->log() as $log) {
    var_dump($log->author->name);
    var_dump($log->author->email);
    var_dump($log->commit);
    var_dump($log->getAbbreviatedCommitHash());
    var_dump($log->date);
    var_dump($log->message);
}
```

---

## Pull Operations

[About git pull](http://git-scm.com/docs/git-pull)

#### -> git pull:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->pull();
```

#### -> git pull 'branch':

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->pull('branch-name');
```

---

## Remote Operations

[About git remote](https://git-scm.com/docs/git-remote)

Use the interface: [ArtARTs36\GitHandler\Contracts\HasRemotes](./src/Contracts/HasRemotes.php)

#### * Has push or fetch remote url

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->hasAnyRemoteUrl('url'));
```

#### -> git remote show origin:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->showRemote());
```

#### -> git remote remove origin:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->removeRemote('origin'));
```

#### -> git remote add <alias> <url>

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->addRemote('alias', 'url'));
```

---

## Tag Operations

[About git tag](http://git-scm.com/docs/git-tag)

Use the interface: [\ArtARTs36\GitHandler\Contracts\Taggable](./src/Contracts/Taggable.php)

#### * check exists tag

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->isTagExists('1.0.0'));
```

#### -> git tag:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getTags());
```

#### -> git tag -l 1.0.*:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getTags('1.0.*'));
```

#### -> git tag -a 1.0.0 -m Version 1.0.0

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->performTag('1.0.0', 'Version 1.0.0'));
var_dump($git->performTag('1.0.0'));
```

---

## Status Operations

[About git status](http://git-scm.com/docs/git-status)

Use the interface: [ArtARTs36\GitHandler\Contracts\Statusable](./src/Contracts/Statusable.php)

#### * Get untracked files:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getUntrackedFiles()); // array<string>
```

#### * Get modified files:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getModifiedFiles()); // array<string>
```

#### * Get added files:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getAddedFiles()); // array<string>
```

#### * Check has changes:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->hasChanges()); // boolean
```

#### -> git status:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->status());
```

#### -> git status --short:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->status(true));
```

---

## Get Paths:

#### -> git --info-path

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getInfoPath());
```

#### -> git --html-path

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getHtmlPath());
```

#### -> git --man-path

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getManPath());
```

---

## Stash Operations

[About git stash](https://git-scm.com/docs/git-stash)

Use the interface: [ArtARTs36\GitHandler\Contracts\Stashable](./src/Contracts/Stashable.php)

#### -> git stash save:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->stash();
$git->stash('message');
```

#### -> git stash list:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
var_dump($git->getStashList());
```

#### -> git stash pop:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->unStash();
```

#### -> git stash apply stash@{1}:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');
$git->applyStash(1);
```

---

## Config Operations

[About git config](http://git-scm.com/docs/git-config)

Use the interface: [ArtARTs36\GitHandler\Contracts\Configurable](./src/Contracts/Configurable.php)

---

Data Objects:

* [\ArtARTs36\GitHandler\Config\Subjects\Core](./src/Config/Subjects/Core.php)
* [\ArtARTs36\GitHandler\Config\Subjects\Credential](./src/Config/Subjects/Credential.php)
* [\ArtARTs36\GitHandler\Config\Subjects\User](./src/Config/Subjects/User.php)
* [\ArtARTs36\GitHandler\Config\Subjects\Pack](./src/Config/Subjects/Pack.php)
* [\ArtARTs36\GitHandler\Config\Subjects\BranchList](./src/Config/Subjects/BranchList.php)<[Branch](./src/Config/Subjects/Branch.php)>

---

#### -> git config user.name test@mail.ru

```php
use \ArtARTs36\GitHandler\GitSimpleFactory;

$git = GitSimpleFactory::factory('/var/web/project');
var_dump($git->setConfig('user', 'name', 'test@mail.ru'));
```

#### -> git config --list

```php
use ArtARTs36\GitHandler\GitSimpleFactory;

$git = GitSimpleFactory::factory('/var/web/project');

var_dump($git->getConfigList());

/** @var \ArtARTs36\GitHandler\Config\Subjects\Pack $pack */
$pack = $git->getConfigSubject('pack');

var_dump($pack->deltaCacheSize);
var_dump($pack->packSizeLimit);
var_dump($pack->sizeLimit);
var_dump($pack->threads);
var_dump($pack->window);
var_dump($pack->windowMemory);
```

----

## Commit operations

[About git commit](https://git-scm.com/docs/git-commit)

#### -> git commit -m="Hello":

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

$git->commit('Hello');
```

#### -> git commit -m="Hello" --amend:

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

$git->commit('Hello', true);
```

#### -> git commit -m="Hello" --amend (with modified files):

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

$git->autoCommit('Hello', true);
```

---

## Hook Management

Use [\ArtARTs36\GitHandler\Contracts\HasHooks](./src/Contracts/HasHooks.php)

Hook names: [\ArtARTs36\GitHandler\Support\HookName](./src/Support/HookName.php)

### * Add hook

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

$git->addHook(\ArtARTs36\GitHandler\Support\HookName::APPLY_PATH_MSG, "echo 'hello'");
```

### * Check hook exists

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

var_dump($git->hasHook(\ArtARTs36\GitHandler\Support\HookName::APPLY_PATH_MSG));
```

### * Delete hook

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

$git->deleteHook(\ArtARTs36\GitHandler\Support\HookName::APPLY_PATH_MSG);
```

### * Get hooks

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

var_dump($git->getHooks());
```

### * Get hook by name

```php
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory('/var/web/project');

var_dump($git->getHook(\ArtARTs36\GitHandler\Support\HookName::APPLY_PATH_MSG));
```

---

## Operations with .gitignore

Use \ArtARTs36\GitHandler\Repository

#### * Add to .gitignore

```php
use ArtARTs36\GitHandler\GitSimpleFactory;

$git = GitSimpleFactory::factory('/var/web/project');
$repository = GitSimpleFactory::factoryRepository($git);

$repository->ignore()->add('/vendor/');

```

#### * Has file in .gitignore

```php
use ArtARTs36\GitHandler\GitSimpleFactory;

$git = GitSimpleFactory::factory('/var/web/project');
$repository = GitSimpleFactory::factoryRepository($git);

$repository->ignore()->has('/vendor/');

``````

#### * Get files paths from .gitignore

```php
use ArtARTs36\GitHandler\GitSimpleFactory;

$git = GitSimpleFactory::factory('/var/web/project');
$repository = GitSimpleFactory::factoryRepository($git);

var_dump($repository->ignore()->files());

```

---

## Download repository

Support download from:
* bitbucket.org
* gitlab.com
* github.com

Example code:

```php
$downloader = \ArtARTs36\GitHandler\GitSimpleFactory::factoryRepositoryDownloader();
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory(__DIR__);

$downloader->download($git, '/path/to/save');
```
