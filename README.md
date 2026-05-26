# ZenPHP Skeleton

Starter project for [ZenPHP](https://github.com/studiokaizen/framework) — a modern, zero-dependency PHP 8.4 micro-framework.

## Requirements

- PHP 8.4+
- Composer
- PDO extension (SQLite or MySQL)
- OpenSSL extension

## Installation

```bash
composer create-project studiokaizen/skeleton my-app
cd my-app
```

## Setup

**1. Copy the config file and fill in your values:**

```bash
cp config.example.php config.php
```

Open `config.php` and set your app name, database connection, and any other settings.

**2. Generate an encryption key:**

```bash
php zen key:generate
```

This writes a secure 32-byte key into `config.php` automatically.

**3. Run migrations:**

```bash
php zen migrate
```

**4. Point your web server's document root to the `public/` directory.**

For local development with PHP's built-in server:

```bash
php -S localhost:8000 -t public
```

---

## Project Structure

```
bootstrap/          Application bootstrap (providers, middleware, error handlers)
config.php          Your local configuration (gitignored)
config.example.php  Configuration template to commit
database/
  migrations/       SQL migration files
  seeders/          SQL seeder files
public/
  index.php         Web entry point — define your routes here
  .htaccess         Apache rewrite rules
resources/
  views/            PHP view templates
src/
  Events/           Application events
  Jobs/             Queued jobs
  Providers/        Service providers (AppServiceProvider wired by default)
storage/
  app/              Private file storage
  cache/            File cache
  logs/             Application logs
zen                 CLI entry point
```

---

## Defining Routes

Open `public/index.php` — it ships with commented examples covering all common patterns. Uncomment and adapt as needed.

```php
use Zen\Http\Request;
use Zen\Http\Response;

$app->get('/', function (Request $request, Response $response) use ($app): Response {
    return $app->view('home');
})->middleware('csrf');

$app->get('/users/:id', function (Request $request, Response $response) use ($app): Response {
    $user = $app['db']->table('users')->find((int) $request->getRouteParam('id'));
    return $app->view('users/show', compact('user'));
})->middleware('csrf', 'auth');
```

---

## Adding Views

Templates live in `resources/views/` and use plain PHP. Extend `layout.php` using sections:

```php
<?php $this->extend('layout'); ?>
<?php $this->start('title'); ?>Page Title<?php $this->end(); ?>
<?php $this->start('content'); ?>

<h1>Hello!</h1>

<?php $this->end(); ?>
```

---

## Adding Migrations

```bash
php zen make:migration create_posts_table
```

Edit the generated file in `database/migrations/`, then run:

```bash
php zen migrate
```

---

## Adding a Queued Job

Create a class in `src/Jobs/` extending `Zen\Queue\Job`:

```php
namespace App\Jobs;

use Zen\Queue\Job;

class SendWelcomeEmail extends Job
{
    public function __construct(
        public readonly string $email,
    ) {}

    public function handle(): void
    {
        // send email
    }
}
```

Dispatch it from a route handler:

```php
$app['queue']->dispatch(new \App\Jobs\SendWelcomeEmail($email));
```

Process the queue:

```bash
php zen queue:work
```

---

## Adding an Event

Create a class in `src/Events/` extending `Zen\Events\Event`:

```php
namespace App\Events;

use Zen\Events\Event;

class UserRegistered extends Event
{
    public function __construct(
        public readonly int    $userId,
        public readonly string $email,
    ) {}
}
```

Register a listener in `src/Providers/AppServiceProvider.php`:

```php
$app['events']->addListener(\App\Events\UserRegistered::class, function ($event) use ($app): void {
    $app['logger']->info("New user #{$event->userId}");
});
```

Dispatch from a route:

```php
$app['events']->dispatch(new \App\Events\UserRegistered($id, $email));
```

---

## Console Commands

```bash
php zen list                    # list all available commands
php zen make:migration <name>   # create a migration
php zen make:seeder <name>      # create a seeder
php zen migrate                 # run pending migrations
php zen migrate:rollback        # roll back last batch
php zen migrate:fresh --seed    # reset + re-migrate + seed
php zen db:seed                 # run all seeders
php zen queue:work              # process queued jobs
php zen schedule:run            # run due scheduled tasks
php zen cache:clear             # clear file cache
php zen key:generate            # generate encryption key
```

---

## Framework Documentation

Full API reference at [studiokaizen/framework](https://github.com/studiokaizen/framework).

---

## License

MIT
