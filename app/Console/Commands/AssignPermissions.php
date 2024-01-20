<?php

namespace App\Console\Commands;

use App\Utilities\Constant;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command gets all unassigned permissions and assigns them to the user role.';

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
     *
     * @return void
     */
    public function handle(): void
    {
        $role = Role::where('name', Constant::type['user'])->first();
        if ($role) {
            $alreadyAssignPermissions = $role->permissions()->pluck('id');
            $permissions = Permission::whereNotIn('id', $alreadyAssignPermissions)->pluck('id');
            if ($permissions)
                $role->givePermissionTo($permissions);
        }
    }
}
