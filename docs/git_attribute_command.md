# Git Attributes

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitAttributeCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitAttributeCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->attributes();
```

---

## Features:

### * Add git attribute

#### Method Signature:

```php
public function add(string $pattern, array $attributes): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->attributes()->add('pattern-test', 'attributes-test');
```

---
### * Find git attribute by pattern

#### Method Signature:

```php
public function find(string $pattern): ArtARTs36\GitHandler\Data\GitAttributes;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->attributes()->find('pattern-test');
```

---
### * Delete git attribute by pattern

#### Method Signature:

```php
public function delete(string $pattern): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->attributes()->delete('pattern-test');
```

---
### * Switch folder to root (project dir)

#### Method Signature:

```php
public function seeToRoot(): static;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->attributes()->seeToRoot();
```

---
### * Switch folder

#### Method Signature:

```php
public function seeToFolder(string $folder): static;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->attributes()->seeToFolder('folder-test');
```

---
