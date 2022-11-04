<?php

namespace Rwxrwx\Installer\Facades;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * @method static array getRoutesConfig(?array $config = null)
 * @method static mixed nextof(string $key)
 * @method static string nextRoute(string $key)
 * @method static string backof(string $key)
 * @method static string backRoute(string $key)
 * @method static string hasBack(string $step)
 * @method static array requirementsCheck()
 *
 * @see \Rwxrwx\Installer\Support\Installer
 */
class Installer extends Facade
{
    /***
     * @inheritdoc
     */
    protected static function getFacadeAccessor(): string
    {
        return \Rwxrwx\Installer\Support\Installer::class;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        if (file_exists(App::storagePath('installed.lock'))) {
            return (new \Rwxrwx\Installer\Support\Installer())->$method(...$args);
        }

        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
