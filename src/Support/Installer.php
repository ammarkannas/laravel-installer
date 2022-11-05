<?php

namespace Rwxrwx\Installer\Support;

use Rwxrwx\Installer\Support\Traits\RequirementsChecker;
use Rwxrwx\Installer\Support\Traits\PermissionsChecker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class Installer
{
    use RequirementsChecker, PermissionsChecker;

    /**
     * Get routes definition config.
     *
     * @param array|null  $config
     * @return array
     */
    public function getRoutesConfig(?array $config = null): array
    {
        $config = $config ?? Config::get('installer.routes');

        return [
            'prefix' => $config['prefix'],
            'as' => $config['name-prefix'],
            'middleware' => $config['install-middleware-group']
        ];
    }

    /**
     * Get next step by key.
     *
     * @param  string $key
     * @return mixed
     */
    public function nextof(string $key): mixed
    {
        $array = Config::get('installer.steps');
        return current(array_slice($array, array_search($key, array_keys($array)) + 1, 1));
    }

    /**
     * Get next step by key.
     *
     * @param  string $key
     * @return mixed
     */
    public function backof(string $key): mixed
    {
        $array = Config::get('installer.steps');
        return current(array_slice($array, array_search($key, array_keys($array)) - 1, 1));
    }

    /**
     * get next step route.
     *
     * @param $key
     * @return string
     */
    public function backRoute($key): string
    {
        return route($this->backof($key));
    }

    /**
     * get next step route.
     *
     * @param $key
     * @return string
     */
    public function nextRoute($key): string
    {
        return route($this->nextof($key));
    }

    /**
     * check if step has back step.
     *
     * @param  $step
     * @return bool
     */
    public function hasBack($step): bool
    {
        return array_key_first(config('installer.steps')) !== $step;
    }

    /**
     * Update .env file.
     *
     * @param  array  $items<string, string>
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function updateEnvironmentFile(array $items): bool|int
    {
        $filesystem = new Filesystem;

        $env = $filesystem->get(App::environmentFilePath());

        foreach ($items as $key => $value)
        {
            $upperCaseKey = strtoupper($key);
            $env = preg_replace("/{$upperCaseKey}=(.*)/", "{$upperCaseKey}={$value}", $env);
        }

        Artisan::call('key:generate');

        return $filesystem->put(App::environmentFilePath(), $env);
    }

    /**
     * Set Environment variable.
     *
     * @param  string  $key
     * @param  string  $value
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function setEnvironmentVariable(string $key, string $value): bool|int
    {
        return $this->updateEnvironmentFile([$key => $value]);
    }
}
