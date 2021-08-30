# Git Archive

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitArchiveCommand](../src/Contracts/Commands/GitArchiveCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->archives();
```

---

## Features:

### * Create git archive

#### Method Signature:



```php
public function create(string $path): void;
```

#### Equals Git Command:

`git archive --output=$path HEAD`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->archives()->create('/path/to/file');
```

---
### * Create archive with .git/refs

#### Method Signature:

```php
public function packRefs(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->archives()->packRefs('/path/to/file');
```

---
### * Unpack archive with .git/refs

#### Method Signature:

```php
public function unpackRefs(string $path): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->archives()->unpackRefs('/path/to/file');
```

---
