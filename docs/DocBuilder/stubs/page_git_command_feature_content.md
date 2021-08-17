### * {$featureName}

Method Signature:

{$featureSuggestsClasses}

```php
{$featureMethodSignature}
```

Equals Git Command:

`{$realGitCommand}`

Example:

```php
use \ArtARTs36\GitHandler\Factory\LocalGitFactory;

$command = (new LocalGitFactory())->factory(__DIR__)->{$factoryMethodName}()->{$featureMethodName}();
```
