<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{
    /**
     * Show installer welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(): Renderable
    {
        return view('installer::welcome');
    }
}
