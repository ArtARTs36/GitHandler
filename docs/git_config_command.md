# Git Config (set, get list, ...)

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand](../src/Contracts/Commands/GitConfigCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->config();
```

---

## Features:

### * Get config list

#### Method Signature:



```php
public function getAll(): ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
```

#### Equals Git Command:

`git config --list`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->config()->getAll();
```

---
### * Get config subject

#### Method Signature:



```php
public function getSubject(string $prefix): ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
```

#### Equals Git Command:

`git config --list`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->config()->getSubject('user');
```

---
### * Set git config

#### Method Signature:



```php
public function set(string $scope, string $field, string $value, bool $replaceAll): bool;
```

#### Equals Git Command:

`git config $scope.$field=$value`

`git config $scope.$field=$value --replace-all`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->config()->set('user', 'name', 'ArtARTs36');
```

---
