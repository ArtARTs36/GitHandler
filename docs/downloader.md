# Repository downloader

Support download from:
* bitbucket.org
* gitlab.com
* github.com

Example code:

```php
$downloader = (new \ArtARTs36\GitHandler\Factory\DownloaderFactory())->factory();
$git = \ArtARTs36\GitHandler\GitSimpleFactory::factory(__DIR__);

$downloader->download($git, '/path/to/save');
```