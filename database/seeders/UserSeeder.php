<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('User.users')->truncate();
        DB::table('User.roles')->truncate();
        $superAdminRole = Role::create(['name' => 'Administrator']); //as super-admin
        $headOfOfficeRole = Role::create(['name' => 'Head And Registering Officer']);
        $registeringOfficerRole = Role::create(['name' => 'Registering Officer']);
        $dealingAssistantRole = Role::create(['name' => 'Dealing Assistant']);
        $workerRole = Role::create(['name' => 'Worker']);
        $officeAdminRole = Role::create(['name' => 'Office Admin']);


        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
//        $officeAdminRole->givePermissionTo(['create role', 'view role', 'update role']);
//        $officeAdminRole->givePermissionTo(['create permission', 'view permission']);
//        $officeAdminRole->givePermissionTo(['create user', 'view user', 'update user']);
//        $superAdminUser = User::firstOrCreate(
//            [
//                'username' => 'Administrator',
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Admin',
//                'lastname' => 'Admin',
//                'phone' => '9089934714',
//                'email' => 'admin@admin.com',
//                'role_id' => 1,
//                'office_id' => 1,
//                'designation_id' => 1,
//                'status' => 1,
//                'district' => 1,
//                'password_change_first_attempt' => true,
//            ]
//        );
//        $superAdminUser->assignRole($superAdminRole);
//
//        $ro1 = User::firstOrCreate(
//            [
//                'username' => 'RO1',
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Test',
//                'lastname' => 'RO',
//                'phone' => '1234567890',
//                'email' => 'test@test.com',
//                'role_id' => 3,
//                'office_id' => 65,
//                'designation_id' => 3,
//                'status' => 1,
//                'district' => 280,
//                'password_change_first_attempt' => true,
//            ]
//        );
//        $ro1->assignRole($registeringOfficerRole);
//
//        $ro2 = User::firstOrCreate(
//            [
//                'username' => 'RO2',
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Adreet',
//                'lastname' => 'Gogoi',
//                'phone' => '9091222222',
//                'email' => 'adgogoi5@gmail.com',
//                'role_id' => 3,
//                'office_id' => 1,
//                'designation_id' => 2,
//                'status' => 0,
//                'district'=> 291,
//                'password_change_first_attempt' => true,
//            ]
//        );
//        $ro2->assignRole($registeringOfficerRole);
//
//        $da1 = User::firstOrCreate(
//            [
//                'username' => 'DA1',
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Test',
//                'lastname' => 'DA',
//                'phone' => '8876634689',
//                'email' => 'hdeka5@gmail.com',
//                'role_id' => 4,
//                'office_id' => 65,
//                'designation_id' => 4,
//                'status' => 1,
//                'district'=> 280,
//                'password_change_first_attempt' => true,
//            ]
//        );
//
//        $da1->assignRole($dealingAssistantRole);
//
//        $da2 = User::firstOrCreate(
//            [
//                'username' => 'DA2',
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Bimal',
//                'lastname' => 'Sarkar',
//                'phone' => '9001222233',
//                'email' => 'bsarkar5@gmail.com',
//                'role_id' => 4,
//                'office_id' => 1,
//                'designation_id' => 1,
//                'status' => 0,
//                'district'=> 280,
//                'password_change_first_attempt' => true,
//            ],
//        );
//
//        $da2->assignRole($dealingAssistantRole);
//
//        $hro = User::firstOrCreate(
//            [
//                'username' => 'HRO_Barpeta'
//            ],
//            [
//
//                'password' => Hash::make('Admin@123'),
//                'firstname' => 'Test',
//                'lastname' => 'RO',
//                'phone' => '1234567890',
//                'email' => 'test@test1.com',
//                'role_id' => 2,
//                'office_id' => 65,
//                'designation_id' => 3,
//                'status' => 1,
//                'district' => 280,
//                'password_change_first_attempt' => true,
//            ]
//        );
//        $hro->assignRole($headOfOfficeRole);


         DB::table('User.users')->truncate();

         $csvFilePath = public_path('app/database_file/users_data.csv');

         $csv = array_map('str_getcsv', file($csvFilePath));
         $headers = array_shift($csv);
         $selectedHeaders = [ "username", "password", "firstname", "lastname", "phone", "email", "role_id", "office_id","district", "designation_id", "status", "password_change_first_attempt"];

         foreach ($csv as $row) {

             $data = array_combine($selectedHeaders, array_slice($row, 1, count($selectedHeaders)));
             $data['created_at'] = now();
             $data['updated_at'] = now();

             $user = User::create($data);
             if ($data['role_id'] == 1) {
                 $user->assignRole($superAdminRole);
             } elseif ($data['role_id'] == 2) {
                 $user->assignRole($headOfOfficeRole);
             } elseif ($data['role_id'] == 3) {
                 $user->assignRole($registeringOfficerRole);
             } elseif ($data['role_id'] == 4) {
                 $user->assignRole($dealingAssistantRole);
             } elseif ($data['role_id'] == 5) {
                 $user->assignRole($workerRole);
             } elseif ($data['role_id'] == 6) {
                 $user->assignRole($officeAdminRole);
             }
         }
    }
}
