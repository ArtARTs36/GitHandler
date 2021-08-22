# Git Index: (git add, git reset, git rm, ...)

---

Use the interface: [ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand](/Users/artem/PhpstormProjects/artarts36/libraries/git/src/Contracts/Commands/GitIndexCommand.php)

---

## Create Instance

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->index();
```

---

## Features:

### * Add file/files to git index

#### Method Signature:



```php
public function add(string|string[] $file, bool $force): bool;
```

#### Equals Git Command:

`git add $file`

`git add $file $file $file`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->index()->add('file-test', true);
```

---
### * Remove file/files from git index

#### Method Signature:



```php
public function remove(string|string[] $files, bool $force): void;
```

#### Equals Git Command:

`git rm $file`

`git rm $file1 $file2 ...`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->index()->remove('files-test', true);
```

---
### * Git Reset

#### Method Signature:

See classes: 

* ArtARTs36\GitHandler\Enum\ResetMode

```php
public function reset(ResetMode $mode, string $subject): void;
```

#### Equals Git Command:

`git reset --$mode $subject`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->index()->reset(ResetMode::from(ResetMode::SOFT), 'subject-test');
```

---
### * Git Reset Head

#### Method Signature:

See classes: 

* ArtARTs36\GitHandler\Enum\ResetMode

```php
public function resetHead(ResetMode $mode): void;
```

#### Equals Git Command:

`git reset --$mode HEAD~`

#### Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->index()->resetHead(ResetMode::from(ResetMode::SOFT));
```

---
