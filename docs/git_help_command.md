# Git Help

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitHelpCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitHelpCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->helps();
```

---

## Features:

### * Get git help information

#### Method Signature:



```php
public function get(): string;
```

#### Equals Git Command:

`git --help`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->helps()->get();
```

---
