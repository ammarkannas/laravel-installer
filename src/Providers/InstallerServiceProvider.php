<?php

namespace Rwxrwx\Installer\Providers;

use Illuminate\Support\Facades\{Config, App};
use Illuminate\Support\ServiceProvider;
use Rwxrwx\Installer\Support\Installer;
use Illuminate\Routing\Router;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (! file_exists(App::storagePath('installed.lock'))) {
            $this->app->singleton(Installer::class, function () {
                return new Installer();
            });
        }

        $this->loadConfig();
        $this->registerPublishes();
    }

    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Routing\Router  $router
     */
    public function boot(Router $router): void
    {
        $this->registerMiddlewares($router);
    }

    /**
     * Load installer config from file if config file not published.
     *
     * @return void
     */
    private function loadConfig(): void
    {
        if (! config('installer')) {
            config(['installer' => require_once __DIR__.'/../config/installer.php']);
        }
    }

    /**
     * Register all installer publishes.
     *
     * @return void
     */
    private function registerPublishes(): void
    {
        // Register config file
        $this->publishes([__DIR__.'/../config/installer.php' => App::configPath('installer.php')], 'installer-config');

        // load and register views files.
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'installer');
        $this->publishes([__DIR__.'/../resources/views' => App::resourcePath('views/vendor/installer')], 'installer-views');

        // load and register route file.
        $this->loadRoutesFrom(__DIR__.'/../routes/installer.php');
        $this->publishes([__DIR__.'/../routes/installer.php' => App::basePath('routes/installer.php')], 'installer-routes');
    }

    /**
     * Register installer middleware from config file.
     *
     * @param \Illuminate\Routing\Router  $router
     * @return void
     */
    private function registerMiddlewares(Router $router): void
    {
        foreach (Config::get('installer.routes.middleware') as $name => $middleware ) {
            $router->middlewareGroup($name, $middleware);
        }
    }
}
