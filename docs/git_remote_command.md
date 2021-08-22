# Git Remote (add, show, remove, ...)

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitRemoteCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->remotes();
```

---

## Features:

### * Git add remote

#### Method Signature:



```php
public function add(string $shortName, string $url): bool;
```

#### Equals Git Command:

`git remote add $shortName $url`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->remotes()->add('shortName-test', 'url-test');
```

---
### * Git show remote

#### Method Signature:



```php
public function show(): ArtARTs36\GitHandler\Data\Remotes;
```

#### Equals Git Command:

`git remote -v`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->remotes()->show();
```

---
### * Remove git remote

#### Method Signature:



```php
public function remove(string $shortName): bool;
```

#### Equals Git Command:

`git remote remove $shortName`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->remotes()->remove('shortName-test');
```

---
### * Has push or fetch remote url

#### Method Signature:

```php
public function hasAnyRemoteUrl(string $url): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->remotes()->hasAnyRemoteUrl('url-test');
```

---
