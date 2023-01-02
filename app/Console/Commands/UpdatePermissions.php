<?php

namespace App\Console\Commands;

use Route;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class UpdatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates & sync the newly created views to have granted permissions upon users and roles.';

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
     * @return mixed
     */
    public function handle()
    {
        $this->createPermissions();
        $this->createSuperAdminRole();
    }  
    
    private function createPermissions(){


        $this->info("Starting Permissions synchronizing...");

        $collection = Route::getRoutes();

        $routes = [];

        $permissions = [];

        $bar = $this->output->createProgressBar(count($collection));

        $bar->start();

        $this->info('');

        foreach ($collection as $route) {

            if ( str_starts_with($route->getPrefix(), 'api/dashboard') ) {

                $routeName = $route->getName();

                $this->info('Synchronizing route ' . $routeName . '...');


                $bar->advance();

                if ($routeName && !in_array($routeName, config('permission.excluded_routes'))) {

                    $routePartials = explode('.', $routeName);

                    $page = $routePartials[0];

                    $action = $routePartials[1];
                    switch (true) {
                        case in_array($action, ['all','index','show']):
                            $permissions[$page . '_view'] = [
                                'page' => $page,
                                'action' => 'view',
                                'name' => $page . ' view',
                                // 'guard_name' => 'sanctum',
                                'guard_name' => 'web',
                            ];
                            break;

                        case in_array($action, ['create', 'store']):
                            $permissions[$page . '_create'] = [
                                'page' => $page,
                                'action' => 'create',
                                'name' => $page . ' create',
                                // 'guard_name' => 'sanctum',
                                'guard_name' => 'web',
                            ];
                            break;

                        case in_array($action, ['edit', 'update']):
                            $permissions[$page . '_edit'] = [
                                'page' => $page,
                                'action' => 'edit',
                                'name' => $page . ' edit',
                                // 'guard_name' => 'sanctum',
                                'guard_name' => 'web',
                            ];
                            break;

                        case in_array($action, ['destory']):
                            $permissions[$page . '_delete'] = [
                                'page' => $page,
                                'action' => 'delete',
                                'name' => $page . ' delete',
                                // 'guard_name' => 'sanctum',
                                'guard_name' => 'web',
                            ];
                            break;

                        default:
                            $permissions[$page . '_' . $action] = [
                                'page' => $page,
                                'action' => $action,
                                'name' => $page . ' ' . $action,
                                // 'guard_name' => 'sanctum',
                                'guard_name' => 'web',
                            ];
                            break;
                    }
                    $routes[] = $routeName;
                }
            }

        }

        $bar->finish();
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ],
                $permission
            );




            // $check = Permission::where('name',$permission['name'])->first();
            // if (!$check) {

            //     Permission::create($permission);
            //     $this->info($permission['name']);
            // }

        }
        $this->info('');

        $this->info('Synchronizing routes of admin portal finished successfully');
    }
    private function createSuperAdminRole()
    {
        $this->info("Starting Role synchronizing...");

        $superAdmin = Role::updateOrCreate([
            'name' => 'super admin',
            // 'guard_name' => 'sanctum',
        ]);

        $superAdmin->syncPermissions(Permission::pluck('name')->toArray());
    }
}
