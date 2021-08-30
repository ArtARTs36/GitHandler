# Git Log

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand](../src/Contracts/Commands/GitLogCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->logs();
```

---

## Features:

### * Get all git logs

#### Method Signature:



```php
public function getAll(): ?ArtARTs36\GitHandler\Data\LogCollection;
```

#### Equals Git Command:

`git log`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->logs()->getAll();
```

---
