## Remote Git Handler

Work with git repository on remote server

----

## Installation:

`composer require artarts36/git-handler`

----

## Usage

```php
use ArtARTs36\GitHandler\Factory\RemoteGitFactory;
use ArtARTs36\ShellCommand\Executors\Ssh\Connection;

$connection = Connection::withPassword('host', 'user', 'password');

$git = (new RemoteGitFactory($connection))->factory('/var/web/project/');

```
