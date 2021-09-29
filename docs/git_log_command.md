
# Git Log

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitLogCommand](../src/Contracts/Commands/GitLogCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->logs();
```

---

## Features:

### * Get all git logs

#### Method Signature:



```php
public function getAll(): ?ArtARTs36\GitHandler\Data\LogCollection;
```

#### Equals Git Command:

`git log`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->logs()->getAll();
```

---
### * Builds log on query

#### Method Signature:

```php
public function get(callable $callback): ?ArtARTs36\GitHandler\Data\LogCollection;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->logs()->get(function (LogQuery $query) {
   $query
        ->offset(3)
        ->before(new \DateTime())
        ->join(function (LogQuery $query) {
            $query
                ->offset(1)
                ->limit(5)
                ->after(new \DateTime('1 month ago'));
        });   
});
```

---
