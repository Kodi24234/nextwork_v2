<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(), // Will be overridden in seeder
            'job_title'    => fake()->jobTitle(),
            'company_name' => fake()->company(),
            'start_date'   => fake()->dateTimeBetween('-5 years', '-2 years'),
            'end_date'     => fake()->dateTimeBetween('-2 years', 'now'),
            'description'  => fake()->paragraph(),
        ];
    }
}
