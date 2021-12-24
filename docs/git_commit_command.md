# Git Commits

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitCommitCommand](../src/Contracts/Commands/GitCommitCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->commits();
```

---

## Features:

### * Execute commit

#### Method Signature:

See classes: 

* [ArtARTs36\GitHandler\Data\Author](/src/Data/Author.php)

```php
public function commit(string $message, bool $amend = false, Author $author = null): bool;
```

#### Equals Git Command:

`git commit -m="{$message}"`

`git commit -m="{$message}" --amend`

`git commit -m="{$message}" --author="$author"`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->commits()->commit('message-test', true, 'author-test');
```

---
### * 

#### Method Signature:



```php
public function autoCommit(string $message, bool $amend = false): bool;
```

#### Equals Git Command:

`git add (untracked files) && git commit -m $message`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->commits()->autoCommit('message-test', true);
```

---
