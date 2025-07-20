<?php
namespace Database\Seeders;

use App\Models\Education;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profile;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRoleSeeder::class);

        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('professional');

            // Profile
            Profile::factory()->create(['user_id' => $user->id]);

            // Related education & work
            Education::factory(rand(1, 2))->create(['user_id' => $user->id]);
            WorkExperience::factory(rand(1, 2))->create(['user_id' => $user->id]);
        });
    }

}
