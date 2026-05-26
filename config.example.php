<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    |
    | Core identity and runtime settings for your application. The debug flag
    | controls whether exceptions are surfaced with full stack traces. Set env
    | to "production" and debug to false before deploying. The key must be
    | exactly 32 bytes and is used by the Encrypter — generate one with
    | `php zen key:generate` and store it securely.
    |
    */

    'app' => [
        'name'     => 'MyApp',
        'env'      => 'local',
        'debug'    => true,
        'url'      => 'http://localhost',
        'timezone' => 'UTC',
        'key'      => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database
    |--------------------------------------------------------------------------
    |
    | Connection settings for the default database. Supported drivers are
    | "sqlite" and "mysql". For SQLite, set database to an absolute path or
    | ":memory:" for an in-memory database. Switch to the mysql block and
    | fill in credentials when connecting to a MySQL server.
    |
    */

    'database' => [
        'default' => 'sqlite',

        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/database/database.sqlite',
        ],

        'mysql' => [
            'driver'   => 'mysql',
            'host'     => '127.0.0.1',
            'port'     => 3306,
            'database' => '',
            'username' => '',
            'password' => '',
            'charset'  => 'utf8mb4',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | The file name for the application log, written relative to the storage/logs
    | directory. Adjust this if you need separate log files per environment or
    | per concern.
    |
    */

    'logging' => [
        'file' => 'app.log',
    ],

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    |
    | The file extension used when resolving template names. Changing this lets
    | you use a custom extension (e.g. "html") without renaming every template
    | file manually.
    |
    */

    'views' => [
        'extension' => 'php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session
    |--------------------------------------------------------------------------
    |
    | Controls the PHP session cookie behaviour. Lifetime is in minutes.
    | Enable secure only on HTTPS deployments. SameSite accepts Strict, Lax,
    | or None (None requires secure to be true).
    |
    */

    'session' => [
        'name'      => 'app_session',
        'lifetime'  => 120,
        'secure'    => false,
        'httponly'  => true,
        'samesite'  => 'Lax',
        'flash_key' => '_flash',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hashing
    |--------------------------------------------------------------------------
    |
    | Controls the algorithm used for password hashing. "bcrypt" and "argon2id"
    | are supported. The rounds option controls the bcrypt work factor — higher
    | values are more secure but slower. 12 is a sensible production default.
    |
    */

    'hashing' => [
        'driver' => 'bcrypt',
        'rounds' => 12,
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS
    |--------------------------------------------------------------------------
    |
    | Controls cross-origin resource sharing. allowed_origins accepts specific
    | origins or ["*"] to allow all. allow_credentials must be true when
    | sending cookies cross-origin (and allowed_origins must not be ["*"]).
    |
    */

    'cors' => [
        'allowed_origins'   => ['*'],
        'allowed_methods'   => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        'allowed_headers'   => ['Content-Type', 'Authorization', 'X-CSRF-Token', 'X-Requested-With'],
        'exposed_headers'   => [],
        'max_age'           => 0,
        'allow_credentials' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | The default cache driver and time-to-live in seconds. The "file" driver
    | stores serialised values under storage/cache. Additional drivers can be
    | added when the Cache component is extended.
    |
    */

    'cache' => [
        'driver' => 'file',
        'ttl'    => 3600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | The default disk and available disk configurations. The "local" disk
    | stores files under storage/app. The "public" disk stores files under
    | public/uploads and exposes them at the /uploads URL prefix.
    |
    */

    'storage' => [
        'default' => 'local',

        'disks' => [
            'local'  => [
                'root' => __DIR__ . '/storage/app',
            ],
            'public' => [
                'root' => __DIR__ . '/public/uploads',
                'url'  => '/uploads',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | The database table and column names used by AuthManager. Change these
    | if your users table uses different field names. The username_field is
    | the column checked during attempt() — typically "email" or "username".
    |
    */

    'auth' => [
        'table'          => 'users',
        'username_field' => 'email',
        'password_field' => 'password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------------
    |
    | The driver controls how mail is sent. Use "log" during development to
    | write messages to storage/logs/mail.log instead of sending them.
    | Switch to "smtp" for production. "sendmail" uses the local MTA.
    |
    */

    'mail' => [
        'driver' => 'log',

        'from' => [
            'address' => 'hello@example.com',
            'name'    => 'MyApp',
        ],

        'smtp' => [
            'host'       => '127.0.0.1',
            'port'       => 587,
            'username'   => '',
            'password'   => '',
            'encryption' => 'tls', // 'tls', 'ssl', or ''
        ],

        'sendmail' => '/usr/sbin/sendmail -bs',
    ],

];
