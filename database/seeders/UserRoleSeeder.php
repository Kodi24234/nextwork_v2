<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if not exist
        $adminRole        = Role::firstOrCreate(['name' => 'admin']);
        $professionalRole = Role::firstOrCreate(['name' => 'professional']);
        $companyRole      = Role::firstOrCreate(['name' => 'company']);

        // Create Super Admin user
        $admin = User::create([
            'name'           => 'Admin User',
            'email'          => 'admin@example.com',
            'password'       => bcrypt('password'),
            'is_super_admin' => true,
        ]);
        $admin->assignRole($adminRole);
    }

}
