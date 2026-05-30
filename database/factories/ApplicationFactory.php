<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id'    => Property::factory(),
            'tenant_id'      => User::factory()->create(['role' => 'tenant'])->id,
            'message'        => $this->faker->paragraph(),
            'monthly_income' => $this->faker->numberBetween(2000, 8000),
            'move_in_date'   => $this->faker->dateTimeBetween('+1 month', '+6 months')->format('Y-m-d'),
            'status'         => 'pending',
            'landlord_notes' => null,
        ];
    }
}
