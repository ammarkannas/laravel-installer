<?php

namespace Rwxrwx\Installer\Support\Traits;

use Illuminate\Support\Facades\Config;

trait RequirementsChecker
{
    /**
     * Requirements check result.
     *
     * @var array|null
     */
    private ?array $requirementsCheckResult = [];

    /**
     * Check requirements for running application.
     *
     * @see \config('installer.requirements')
     *
     * @return self
     */
    public function requirementsCheck(): self
    {
        $this->checkPhpVersion(Config::get('installer.php-version'));
        $this->checkPhpExtensions(Config::get('installer.requirements.php-extensions'));

        if ($this->isApacheServer() !== false) {
            $this->checkApacheMods(Config::get('installer.requirements.apache-mods'));
        }

        return $this;
    }

    /**
     * Check php version.
     *
     * @param  string  $minimum
     * @return self
     */
    public function checkPhpVersion(string $minimum): self
    {
        if (version_compare(phpversion(), $minimum) <= 0) {
            $this->requirementsCheckResult['phpversion'] = false;
            $this->requirementsCheckResult['error'] = true;
        } else {
            $this->requirementsCheckResult['phpversion'] = true;
        }

        return $this;
    }

    /**
     * Check php extension is loaded or not.
     *
     * @param  array  $extensions
     * @return self
     */
    public function checkPhpExtensions(array $extensions): self
    {
        foreach ($extensions as $extension) {
            if (extension_loaded($extension)) {
                $this->requirementsCheckResult[$extension] = true;
                continue;
            }

            $this->requirementsCheckResult[$extension] = false;
            $this->requirementsCheckResult['error'] = true;
        }

        return $this;
    }

    /**
     * Check if apache modules loaded Apache modules.
     *
     * @param  array  $modules
     * @return self
     */
    public function checkApacheMods(array $modules): self
    {
        foreach ($modules as $module) {
            if (in_array($module, apache_get_modules())) {
                $this->requirementsCheckResult[$module] = true;
                continue;
            }

            $this->requirementsCheckResult[$module] = false;
            $this->requirementsCheckResult['error'] = true;
        }

        return $this;
    }

    /**
     * check if server software is apache.
     *
     * @return bool|int
     */
    public function isApacheServer(): bool|int
    {
        return stripos($_SERVER['SERVER_SOFTWARE'], 'apache');
    }

    /**
     * Get requirements check result.
     *
     * @return array
     */
    public function requirementsCheckResult(): array
    {
        return $this->requirementsCheckResult;
    }
}
