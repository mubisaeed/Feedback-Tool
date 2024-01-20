<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class LoadPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command gets all of the routes and pulls the first middleware off each route to guess the permissions the route uses. We then check if the permission exists and if not, we create the permission. The permissions are NOT assigned to a role automatically.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $routes = Route::getRoutes();
        $bar = $this->getOutput()->createProgressBar(count($routes));
        foreach ($routes as $val) {
            if (isset($val->action['middleware']) && is_array($val->action['middleware'])) {
                $middleware = $val->action['middleware'][count($val->action['middleware']) - 1];
                if (strchr($middleware, 'permission.check')) {
                    $permissions = explode(':', $middleware);
                    if (count($permissions) > 0) {
                        $permission = $permissions[count($permissions) - 1];
                        if ($permission) {
                            Permission::firstOrCreate([
                                'name' => $permission,
                            ]);
                        }
                    }
                }
            }
            $bar->advance();
        }
    }
}
