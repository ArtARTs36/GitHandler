# Git Submodule

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand](../src/Contracts/Commands/GitSubmoduleCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->submodules();
```

---

## Features:

### * Add git submodule

#### Method Signature:



```php
public function add(string $url): void;
```

#### Equals Git Command:

`git submodule add $url`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->add('url-test');
```

---
### * Get all submodules

#### Method Signature:

```php
public function getAll(): array<string,\Submodule>;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->getAll();
```

---
### * Remove submodule

#### Method Signature:

```php
public function remove(string $name): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->remove('name-test');
```

---
### * Determine is exists submodule

#### Method Signature:

```php
public function exists(string $name): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->exists('name-test');
```

---
### * Sync git submodule

#### Method Signature:



```php
public function sync(string $name): void;
```

#### Equals Git Command:

`git submodule sync $name`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->sync('name-test');
```

---
### * Sync defines in .gitmodules from git config

#### Method Signature:

```php
public function syncDefinesFromConfig(): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->submodules()->syncDefinesFromConfig();
```

---
