# Git Init

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitSetupCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitSetupCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->setup();
```

---

## Features:

### * Init git repository

#### Method Signature:



```php
public function init(): bool;
```

#### Equals Git Command:

`git init`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->setup()->init();
```

---
### * Check for init repository

#### Method Signature:

```php
public function isInit(): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->setup()->isInit();
```

---
### * Git Clone

#### Method Signature:



```php
public function clone(string $url, string $branch, string $folder): bool;
```

#### Equals Git Command:

`git clone $url`

`git clone $url -b $branch`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->setup()->clone('url-test', 'master', 'folder-test');
```

---
### * Delete this repository

#### Method Signature:

```php
public function delete(): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->setup()->delete();
```

---
### * Delete local repository and fetch from origin

#### Method Signature:

```php
public function reinstall(string $branch): void;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->setup()->reinstall('master');
```

---
