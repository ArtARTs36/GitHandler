# Git Paths (info-path, html-path, man-path, ...)

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitPathCommand](../src/Contracts/Commands/GitPathCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->paths();
```

---

## Features:

### * Get git info path

#### Method Signature:



```php
public function info(): string;
```

#### Equals Git Command:

`git --info-path`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->paths()->info();
```

---
### * Get git html path

#### Method Signature:



```php
public function html(): string;
```

#### Equals Git Command:

`git --html-path`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->paths()->html();
```

---
### * Get git info path

#### Method Signature:



```php
public function man(): string;
```

#### Equals Git Command:

`git --man-path`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->paths()->man();
```

---
