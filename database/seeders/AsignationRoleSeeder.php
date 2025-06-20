<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AsignationRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $adminRole->givePermissionTo([
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',
        ]);

        $user = User::find(2);

        if ($user) {
            $user->assignRole($adminRole);
        } else {
            $this->command->error('El usuario con ID 2 no existe.');
        }


    }
}
