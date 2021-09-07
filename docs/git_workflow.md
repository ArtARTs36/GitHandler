# Git Workflow (dump and restore git features)

Use the interface: [ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflow](../src/Contracts/Workflow/GitWorkflow.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->workflow();
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

(new LocalGitFactory())->factory(__DIR__)->workflow()->dump('/path/to/file');
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

(new LocalGitFactory())->factory(__DIR__)->workflow()->dumpWith('/path/to/file', function (DumpBuilding $building) {
    $building->withHooks();
});
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

(new LocalGitFactory())->factory(__DIR__)->workflow()->restore('/path/to/file');
```

---
