# Git Workflow (dump and restore git features)

Use the interface: [ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow](../src/Contracts/Workflow/GitWorkflow.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->backups();
```

---

## Features:

### * Dump workflow

#### Method Signature:

```php
public function dump(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backups()->dump('/path/to/file');
```

---
### * Dump workflow

#### Method Signature:

```php
public function dumpWith(string $path, callable $building): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backups()->dumpWith('/path/to/file', 'building-test');
```

---
### * Restore workflow

#### Method Signature:

```php
public function restore(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backups()->restore('/path/to/file');
```

---
