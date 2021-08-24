# Git Hooks

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitHookCommand](../src/Contracts/Commands/GitHookCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->hooks();
```

---

## Features:

### * Add git Hook

#### Method Signature:
See classes: 

* [ArtARTs36\GitHandler\Enum\HookName](/src/Enum/HookName.php)
```php
public function add(HookName $name, string $script): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->add(HookName::from(HookName::APPLY_PATH_MSG), 'script-test');
```

---
### * Check exists Hook

#### Method Signature:
See classes: 

* [ArtARTs36\GitHandler\Enum\HookName](/src/Enum/HookName.php)
```php
public function has(HookName $name): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->has(HookName::from(HookName::APPLY_PATH_MSG));
```

---
### * Delete hook by name

#### Method Signature:
See classes: 

* [ArtARTs36\GitHandler\Enum\HookName](/src/Enum/HookName.php)
```php
public function delete(HookName $name): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->delete(HookName::from(HookName::APPLY_PATH_MSG));
```

---
### * Get hook information by name

#### Method Signature:
See classes: 

* [ArtARTs36\GitHandler\Enum\HookName](/src/Enum/HookName.php)
```php
public function get(HookName $name): ArtARTs36\GitHandler\Data\Hook;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->get(HookName::from(HookName::APPLY_PATH_MSG));
```

---
### * Get all hooks

#### Method Signature:

```php
public function getAll(bool $onlyWorked): array<string,\Hook>;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->getAll(true);
```

---
### * Get path to hooks storage

#### Method Signature:

```php
public function getHookPath(string $name): string;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->hooks()->getHookPath('name-test');
```

---
