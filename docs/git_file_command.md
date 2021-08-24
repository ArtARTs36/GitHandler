# Git Files

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitFileCommand](../src/Contracts/Commands/GitFileCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->files();
```

---

## Features:

### * Create file in git repository

#### Method Signature:

```php
public function createFile(string $name, string $content, string $folder): string;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->files()->createFile('name-test', 'content-test', 'folder-test');
```

---
### * Create folder in git repository

#### Method Signature:

```php
public function createFolder(string $name): self;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->files()->createFolder('name-test');
```

---
