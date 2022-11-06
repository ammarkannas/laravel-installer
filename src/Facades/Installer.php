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
 * @method static \Rwxrwx\Installer\Support\Traits\RequirementsChecker  requirementsCheck()
 * @method static \Rwxrwx\Installer\Support\Traits\RequirementsChecker checkPhpVersion(string $minimum)
 * @method static \Rwxrwx\Installer\Support\Traits\RequirementsChecker checkApacheMods(array $modules)
 * @method static \Rwxrwx\Installer\Support\Traits\RequirementsChecker checkPhpExtensions(array $extensions)
 * @method static bool isApacheServer()
 * @method static array requirementsCheckResult()
 * @method static \Rwxrwx\Installer\Support\Traits\PermissionsChecker permissionsCheck()
 * @method static string getPermission($folder)
 * @method static array permissionsCheckResult()
 * @method static bool|int updateEnvironmentFile(array $items)
 * @method static bool|int setEnvironmentVariable(string $key, string $value)
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
     * @param string $method
     * @param array  $args
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (file_exists(App::storagePath('installed.lock'))) {
            return (new \Rwxrwx\Installer\Support\Installer())->$method(...$args);
        }

        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
