<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(), // Will be overridden in seeder
            'institution_name' => fake()->company() . ' University',
            'degree'           => fake()->randomElement(['BSc', 'MSc', 'MBA']),
            'field_of_study'   => fake()->word(),
            'start_date'       => fake()->dateTimeBetween('-10 years', '-6 years'),
            'end_date'         => fake()->dateTimeBetween('-5 years', '-1 year'),
            'description'      => fake()->sentence(),
        ];
    }
}
