# Git Push

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitPushCommand](../src/Contracts/Commands/GitPushCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->pushes();
```

---

## Features:

### * Push to remote git

#### Method Signature:



```php
public function push(bool $force = false, ?string $upStream = null): bool;
```

#### Equals Git Command:

`git push`

`git push --force`

`git push --force set-upstream $upStream`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->pushes()->push(true, 'upStream-test');
```

---
### * Push to remote git through current-branch

#### Method Signature:



```php
public function pushOnAutoSetUpStream(bool $force = false): bool;
```

#### Equals Git Command:

`git push --set-upstream origin {current-branch}`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->pushes()->pushOnAutoSetUpStream(true);
```

---
### * Push all git tags

#### Method Signature:



```php
public function pushAllTags(bool $force = false, ?string $upStream = null): bool;
```

#### Equals Git Command:

`git push --tags`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->pushes()->pushAllTags(true, 'upStream-test');
```

---
