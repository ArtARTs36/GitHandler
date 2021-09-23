# Git Backup (dump and restore git features)

Use the interface: [ArtARTs36\GitHandler\Contracts\Backup\GitBackup](../src/Contracts/Backup/GitBackup.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->backup();
```

---

## Features:

### * Dump backup

#### Method Signature:

```php
public function dump(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backup()->dump('/path/to/file');
```

---
### * Dump backup

#### Method Signature:

```php
public function dumpOnly(string $path, array $elements): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backup()->dumpOnly('/path/to/file', 'elements-test');
```

---
### * Restore backup

#### Method Signature:

```php
public function restore(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backup()->restore('/path/to/file');
```

---
### * Restore backup

#### Method Signature:

```php
public function restoreOnly(string $path, array $elements): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->backup()->restoreOnly('/path/to/file', 'elements-test');
```

---
