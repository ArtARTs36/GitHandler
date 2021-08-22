# Git Status

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitStatusCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitStatusCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses();
```

---

## Features:

### * Get git status

#### Method Signature:



```php
public function status(bool $short): ArtARTs36\Str\Str;
```

#### Equals Git Command:

`git status`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses()->status(true);
```

---
### * Check has changes

#### Method Signature:

```php
public function hasChanges(): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses()->hasChanges();
```

---
### * Get untracked files

#### Method Signature:

```php
public function getUntrackedFiles(): array;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses()->getUntrackedFiles();
```

---
### * Get modified files

#### Method Signature:

```php
public function getModifiedFiles(): array;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses()->getModifiedFiles();
```

---
### * Get added files

#### Method Signature:

```php
public function getAddedFiles(): array;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->statuses()->getAddedFiles();
```

---
