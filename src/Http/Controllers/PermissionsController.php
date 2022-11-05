<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Rwxrwx\Installer\Facades\Installer;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Show install check server requirements page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(): Renderable
    {
        $permissions = collect(Installer::permissionsCheck()->permissionsCheckResult());
        return view('installer::permissions', compact('permissions'));
    }
}
