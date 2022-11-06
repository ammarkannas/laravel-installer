<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Rwxrwx\Installer\Facades\Installer;

class ServerRequirementsController extends Controller
{
    /**
     * Show install check server requirements page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(): Renderable
    {
        $requirements = collect(Installer::requirementsCheck()->requirementsCheckResult());

        return view('installer::server-requirements', compact('requirements'));
    }
}
