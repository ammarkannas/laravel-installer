<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Rwxrwx\Installer\Facades\Installer;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class EnvironmentSetupController extends Controller
{
    /**
     * Show installer welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(): Renderable
    {
        return view('installer::environment-setup');
    }

    public function store(Request $request)
    {
        $errors = [];
        try {
            if (Installer::updateEnvironmentFile($request->toArray()) !== false) {
                return redirect(Installer::nextRoute('environment-setup'));
            }

            $errors = ['unexpected' => __('An unexpected error has occurred')];
        } catch (FileNotFoundException $fileNotFoundException) {
            $errors = ['file-not-found' => __('.env file not found'),];
        }

        return redirect()
            ->back()
            ->withInput($request->toArray())
            ->withErrors($errors);
    }
}
