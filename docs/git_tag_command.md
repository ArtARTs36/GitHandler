# Git Tags

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitTagCommand](../src/Contracts/Commands/GitTagCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->tags();
```

---

## Features:

### * Get all git tags

#### Method Signature:



```php
public function getAll(?string $pattern): string[];
```

#### Equals Git Command:

`git tag`

`git tag -l=$pattern`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->tags()->getAll('pattern-test');
```

---
### * Add git tag

#### Method Signature:



```php
public function add(string $tag, ?string $message): bool;
```

#### Equals Git Command:

`git -a $tag`

`git -a $tag -m $message`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->tags()->add('tag-test', 'message-test');
```

---
### * Check tag exists

#### Method Signature:

```php
public function exists(string $tag): bool;
```

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->tags()->exists('tag-test');
```

---
### * Get git tag information

#### Method Signature:



```php
public function get(string $tagName): ArtARTs36\GitHandler\Data\Tag;
```

#### Equals Git Command:

`git show $tagName`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

(new LocalGitFactory())->factory(__DIR__)->tags()->get('tagName-test');
```

---
