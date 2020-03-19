<?php

namespace App\Console\Commands;

use Domain\Users\Contracts\Role as RoleContract;
use Illuminate\Console\Command;

class CreateRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova:role
                            {name : The name of the role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new role';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role = app(RoleContract::class)::findOrCreate($this->argument('name'));

        $this->info("Role \"{$role->name}\" created");
    }
}
