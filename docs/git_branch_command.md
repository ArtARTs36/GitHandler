# Git Branches

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitBranchCommand](../src/Contracts/Commands/GitBranchCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->branches();
```

---

## Features:

### * Delete Branch

#### Method Signature:



```php
public function delete(string $branch): bool;
```

#### Equals Git Command:

`git branch -d {$branch}`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->branches()->delete('master');
```

---
### * Create new Branch

#### Method Signature:



```php
public function create(string $branch): void;
```

#### Equals Git Command:

`git branch {$branch}`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->branches()->create('master');
```

---
### * Get all Branches

#### Method Signature:



```php
public function getAll(): string[];
```

#### Equals Git Command:

`git branch -a`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->branches()->getAll();
```

---
### * Switch to Branch

#### Method Signature:



```php
public function switch(string $branch): bool;
```

#### Equals Git Command:

`git switch {$branch}`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->branches()->switch('master');
```

---
### * Get current Branch

#### Method Signature:



```php
public function current(): ArtARTs36\Str\Str;
```

#### Equals Git Command:

`git branch --show-current`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->branches()->current();
```

---
