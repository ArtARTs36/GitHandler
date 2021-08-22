# Git Pull

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitPullCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitPullCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->pulls();
```

---

## Features:

### * Pull changes from git remote

#### Method Signature:



```php
public function pull(): bool;
```

#### Equals Git Command:

`git pull`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->pulls()->pull();
```

---
### * Pull changes from git remote

#### Method Signature:



```php
public function pullBranch(string $branch): bool;
```

#### Equals Git Command:

`git pull $branch`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->pulls()->pullBranch('master');
```

---
