# Demo Auth Adapter for FileGator

This adapter is the simplest showcase for the Auth adapter structure. It will add a single demo user to the FileGator app.

## Requirements

FileGator v7+

## Install

1. Copy `DemoAuth.php` file to `filegator/backend/Services/Auth/Adapters/`

2. Replace your current Auth handler in `configuration.php` file like this:

```
        'Filegator\Services\Auth\AuthInterface' => [
            'handler' => '\Filegator\Services\Auth\Adapters\DemoAuth',
            'config' => [
                'name' => 'Test User',
                'username' => 'user@example.com',
                'password' => 'user123',
                'role' => 'user',
                'permissions' => ['read', 'write', 'upload', 'download', 'batchdownload', 'zip'],
                'homedir' => '/',
            ],
        ],
```

