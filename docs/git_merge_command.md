# Git Merge

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitMergeCommand](../src/Contracts/Commands/GitMergeCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->merges();
```

---

## Features:

### * Merge with branch

#### Method Signature:



```php
public function merge(string $branch, string $message): void;
```

#### Equals Git Command:

`git merge $branch`

`git merge $branch -m=$message`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->merges()->merge('master', 'message-test');
```

---
### * Squash Merge with branch

#### Method Signature:



```php
public function mergeSquash(string $branch, string $message): void;
```

#### Equals Git Command:

`git merge $branch --squash`

`git merge $branch -m=$message --squash`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->merges()->mergeSquash('master', 'message-test');
```

---
### * Abort merge

#### Method Signature:



```php
public function abort(): void;
```

#### Equals Git Command:

`git merge --abort`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->merges()->abort();
```

---
