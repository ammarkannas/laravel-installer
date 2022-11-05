<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Rwxrwx\Installer\Facades\Installer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
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

    /**
     * update environment (.env) file.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse|Response
    {
        return $this->updateEnvironment($request, 'environment-setup');
    }

    /**
     * update environment (.env) file.
     *
     * @param \Illuminate\Http\Request  $request
     * @param string $step
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    private function updateEnvironment(Request $request, string $step): RedirectResponse|Response
    {
        $errors = [];
        try {
            if (Installer::updateEnvironmentFile($request->toArray()) !== false) {
                return redirect(Installer::nextRoute($step));
            }

            $errors = ['unexpected' => __('An unexpected error has occurred')];
        } catch (FileNotFoundException $fileNotFoundException) {
            $errors = ['file-not-found' => __('.env file not found'),];
        }

        return redirect()->back()->withInput($request->toArray())
            ->withErrors($errors);
    }
}
