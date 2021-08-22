# Git Ignore Files (.gitignore)

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitIgnoreCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitIgnoreCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->ignores();
```

---

## Features:

### * Get ignored files

#### Method Signature:

```php
public function files(): string[];
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->files();
```

---
### * Add file to .gitignore

#### Method Signature:

```php
public function add(string $path): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->add('/path/to/file');
```

---
### * Delete path from .gitignore

#### Method Signature:

```php
public function delete(string $path): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->delete('/path/to/file');
```

---
### * Has file in .gitignore

#### Method Signature:

```php
public function has(string $path): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->has('/path/to/file');
```

---
### * Get full path to file ".gitignore"

#### Method Signature:

```php
public function getPath(): string;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->getPath();
```

---
### * 

#### Method Signature:

```php
public function seeToRoot(): static;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->seeToRoot();
```

---
### * 

#### Method Signature:

```php
public function seeToFolder(string $folder): static;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->ignores()->seeToFolder('folder-test');
```

---
