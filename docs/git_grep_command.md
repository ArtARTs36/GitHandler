# Git grep

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitGrepCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitGrepCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->greps();
```

---

## Features:

### * Git grep

#### Method Signature:



```php
public function grep(string $term): \FileMatch[];
```

#### Equals Git Command:

`git grep -n $term`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->greps()->grep('term-test');
```

---
