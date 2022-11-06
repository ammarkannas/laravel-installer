<?php

namespace Rwxrwx\Installer\Http\Controllers;

use Illuminate\Console\BufferedConsoleOutput;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Rwxrwx\Installer\Facades\Installer;

class DatabaseSetupController extends Controller
{
    /**
     * Show installer welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(): Renderable
    {
        $supportedDatabases = [
            'Sqlite' => 'sqlite',
            'Mysql' => 'mysql',
            'PostgreSQL' => 'pgsql',
            'Microsoft SQL Server' => 'sqlsrv',
        ];

        return view('installer::database-setup', compact('supportedDatabases'));
    }

    /**
     * store database setup in (.env) file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse|Response
    {
        try {
            Config::set('database.default', $request->input('db_connection'));
            $connection = Config::get('database.default');
            Config::set("database.connections.{$connection}.host", $request->input('db_host'));
            Config::set("database.connections.{$connection}.port", $request->input('db_port'));
            Config::set("database.connections.{$connection}.database", $request->input('db_database'));
            Config::set("database.connections.{$connection}.username", $request->input('db_username'));
            Config::set("database.connections.{$connection}.password", $request->input('db_password'));
            $pdo = DB::connection()->getPdo();
        } catch (\PDOException $exception) {
            return redirect()->back()->withInput($request->toArray())
                ->withErrors(['connection' => $exception->getMessage()]);
        }

        return $this->updateEnvironment($request, 'database-setup');
    }

    /**
     * update environment (.env) file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $step
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
            $errors = ['file-not-found' => __('.env file not found')];
        }

        return redirect()->back()->withInput($request->toArray())
            ->withErrors($errors);
    }

    /**
     * show database migrations page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showMigrations(): Renderable
    {
        return view('installer::database-migrations');
    }

    /**
     * run database migrations script.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function runMigrations(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->isXmlHttpRequest()) {
            $output = new BufferedConsoleOutput();
            Artisan::call('migrate:fresh', [], $output);

            return response()->json(['status' => 'success', 'message' => $output->fetch()]);
        }

        return Redirect::to(Installer::nextRoute('database-migrations'));
    }
}
