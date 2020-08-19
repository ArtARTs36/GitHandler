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
