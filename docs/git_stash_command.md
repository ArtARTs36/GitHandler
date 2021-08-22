# Git Stash

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitStashCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitStashCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->stashes();
```

---

## Features:

### * Git stash changes

#### Method Signature:



```php
public function stash(string $message): bool;
```

#### Equals Git Command:

`git stash`

`git stash save $message`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->stashes()->stash('message-test');
```

---
### * Git stash pop

#### Method Signature:



```php
public function pop(): bool;
```

#### Equals Git Command:

`git stash pop`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->stashes()->pop();
```

---
### * Get all git stashes

#### Method Signature:



```php
public function getList(): array;
```

#### Equals Git Command:

`git stash --list`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->stashes()->getList();
```

---
### * Git apply stash

#### Method Signature:



```php
public function apply(int $id): bool;
```

#### Equals Git Command:

`git apply stash stash@{$id}`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->stashes()->apply(1);
```

---
