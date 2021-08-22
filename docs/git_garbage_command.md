# Collect garbage

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitGarbageCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitGarbageCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->garbage();
```

---

## Features:

### * Collect garbage

#### Method Signature:

See classes: 

* [ArtARTs36\GitHandler\Enum\GarbageCollectMode](/src/Enum/GarbageCollectMode.php)

```php
public function collect(GarbageCollectMode $mode): bool;
```

#### Equals Git Command:

`git gc --$mode`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->garbage()->collect(GarbageCollectMode::from(GarbageCollectMode::AUTO));
```

---
### * Collect garbage on older date

#### Method Signature:

See classes: 

* [ArtARTs36\GitHandler\Enum\GarbageCollectMode](/src/Enum/GarbageCollectMode.php)

```php
public function collectOnDate(GarbageCollectMode $mode, DateTimeInterface $date): bool;
```

#### Equals Git Command:

`git gc --$mode --prune=$date`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->garbage()->collectOnDate(GarbageCollectMode::from(GarbageCollectMode::AUTO), 'date-test');
```

---
