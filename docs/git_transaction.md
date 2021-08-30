# Git Transactions

Use the interface: [ArtARTs36\GitHandler\Contracts\Transaction\GitTransaction](../src/Contracts/Transaction/GitTransaction.php)

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
public function attempt(callable $callback): mixed;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->transaction()->attempt(function (GitHandler $git) {
    $git->merges()->merge('master');
});
```

---
