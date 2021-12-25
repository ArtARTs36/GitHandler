# Git fetch (git fetch, git fetch --all, ...)

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitFetchCommand](../src/Contracts/Commands/GitFetchCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->fetches();
```

---

## Features:

### * Git fetch

#### Method Signature:



```php
public function fetch(): void;
```

#### Equals Git Command:

`git fetch`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->fetches()->fetch();
```

---
### * Git fetch all

#### Method Signature:



```php
public function fetchAll(): void;
```

#### Equals Git Command:

`git fetch --all`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->fetches()->fetchAll();
```

---
