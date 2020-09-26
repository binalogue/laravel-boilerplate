<?php

namespace App\Console\Users;

use Domain\Users\Contracts\Role as RoleContract;
use Illuminate\Console\Command;

class CreateRoleCommand extends Command
{
    protected $signature = 'nova:role
                            {name : The name of the role}';

    protected $description = 'Create a new role';

    public function handle()
    {
        /** @var \Domain\Users\Models\Role */
        $role = app(RoleContract::class)::findOrCreate($this->argument('name'));

        $this->info("Role \"{$role->name}\" created");
    }
}
