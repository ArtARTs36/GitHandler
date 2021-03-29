## Git Handler

![PHP Composer](https://github.com/ArtARTs36/GitHandler/workflows/PHP%20Composer/badge.svg?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
<a href="https://poser.pugx.org/artarts36/git-handler/d/total.svg">
    <img src="https://poser.pugx.org/artarts36/git-handler/d/total.svg" alt="Total Downloads">
</a>

----

### Description:

Tool for work with git

---

### Installation:

`composer require artarts36/git-handler`

----

### Examples:

#### git init:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->init();
```

#### check if the repository is initialized :

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->isInit());
```

#### git clone:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->clone('https://github.com/ArtARTs36/GitHandler');
```

#### git pull:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->pull();
```

#### git pull 'branch':

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->pull('branch-name');
```

#### git checkout:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->checkout('branch-name');
```

#### git status:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->status());
```

#### git status --short:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->status(true));
```

#### git add:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->add('file_name'));
```

#### git stash:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->stash();
$git->stash('message');
```

#### git remote show origin:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->showRemote());
```

#### git fetch:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->fetch();
```

#### git push:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$git->push();
```

#### git log:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');

foreach ($git->log() as $log) {
    var_dump($log->author->name);
    var_dump($log->author->email);
    var_dump($log->commit);
    var_dump($log->getAbbreviatedCommitHash());
    var_dump($log->date);
    var_dump($log->message);
}
```

#### git commit -m="Hello":

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');

$git->commit('Hello');
```

#### git commit -m="Hello" --amend:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');

$git->commit('Hello', true);
```

#### git tag:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->getTags());
```

#### git tag -l 1.0.*:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->getTags('1.0.*'));
```

### git tag -a 1.0.0 -m Version 1.0.0

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->performTag('1.0.0', 'Version 1.0.0'));
var_dump($git->performTag('1.0.0'));
```

### git remote add <alias> <url>

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->addRemote());
```

### check exists tag

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
var_dump($git->isTagExists('1.0.0'));
```

#### create folder in repository:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$action = new \ArtARTs36\GitHandler\Action($git);

$action->createFolder('folder_name');
```

#### create file in repository:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$action = new \ArtARTs36\GitHandler\Action($git);

$action->createFile('file.php', 'echo hello world');
$action->createFile('file.php', 'echo hello world', 'folder_name');
```

#### delete repository:

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$action = new \ArtARTs36\GitHandler\Action($git);

$action->delete();
```

#### reinstall repository (Delete local repository and fetch from origin):

```php
use ArtARTs36\GitHandler\Git;

$git = new Git('/var/web/project');
$action = new \ArtARTs36\GitHandler\Action($git);

$action->reinstall();
```
