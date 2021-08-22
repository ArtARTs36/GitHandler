# Git Transactions

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Transaction/GitTransaction.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->transaction();
```

---

## Features:

### * Execute transaction

#### Method Signature:

```php
public function attempt(callable $callback): ;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->transaction()->attempt('callback-test');
```

---
