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
### * Get git log for file

#### Method Signature:



```php
public function logForFile(string $filename): ?ArtARTs36\GitHandler\Data\LogCollection;
```

#### Equals Git Command:

`git log $filename`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->logs()->logForFile('filename-test');
```

---
### * Get git log for file on lines

#### Method Signature:



```php
public function logForFileOnLines(string $filename, int $startLine, int $endLine): ?ArtARTs36\GitHandler\Data\LogCollection;
```

#### Equals Git Command:

`git log -L $startLine:$endLine $filename`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->logs()->logForFileOnLines('filename-test', 1, 1);
```

---
