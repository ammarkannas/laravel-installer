<?php

namespace Rwxrwx\Installer\Support\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

trait PermissionsChecker
{
    /**
     * Permissions check result.
     *
     * @var array|null
     */
    private ?array $permissionsCheckResult = [];

    /**
     * Check permissions for folders.
     * @see \config('installer.permissions')
     *
     * @return self
     */
    public function permissionsCheck(): self
    {
        foreach (Config::get('installer.permissions') as $folder => $permission) {
            if (! ($this->getPermission($folder) >= $permission)) {
                $this->permissionsCheckResult[$folder] = false;
                $this->permissionsCheckResult['error'] = true;
                continue;
            }

            $this->permissionsCheckResult[$folder] = true;
        }

        return $this;
    }

    /**
     * Get a folder permission.
     *
     * @param $folder
     * @return string
     */
    public function getPermission($folder): string
    {
        return substr(sprintf('%o', fileperms(App::basePath($folder))), -4);
    }

    /**
     * Get permissions check result.
     *
     * @return array
     */
    public function permissionsCheckResult(): array
    {
        return $this->permissionsCheckResult;
    }
}
