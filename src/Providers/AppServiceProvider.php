<?php

declare(strict_types=1);

namespace App\Providers;

use Zen\Application;
use Zen\DependencyInjection\BootableProviderInterface;
use Zen\DependencyInjection\ServiceProviderInterface;

class AppServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Application $app): void
    {
        //
    }

    public function boot(Application $app): void
    {
        $app['view']->share('auth', $app['auth']);
        $app['view']->share('session', $app['session']);
    }
}
