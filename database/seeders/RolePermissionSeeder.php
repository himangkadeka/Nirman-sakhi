<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('User.permissions')->truncate();

        $csvFilePath = public_path('app/database_file/permissions.csv');

        $csv = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csv);
        $selectedHeaders = ['name', 'guard_name'];

        foreach ($csv as $row) {

            $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('User.permissions')->insert($data);
        }

        // Create Role

        // $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        // $adminRole = Role::create(['name' => 'office-admin']);

        // Lets give all permission to super-admin role.
        // $allPermissionNames = Permission::pluck('name')->toArray();

        // $superAdminRole->givePermissionTo($allPermissionNames);

        // // Let's give few permissions to admin role.
        // $adminRole->givePermissionTo(['create role', 'view role', 'update role']);
        // $adminRole->givePermissionTo(['create permission', 'view permission']);
        // $adminRole->givePermissionTo(['create user', 'view user', 'update user']);


    }
}
