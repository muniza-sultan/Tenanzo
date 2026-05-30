<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
       return [
            'user_id'      => User::factory()->create(['role' => 'landlord'])->id,
            'title'        => $this->faker->sentence(3),
            'address'      => $this->faker->address(),
            'monthly_rent' => $this->faker->numberBetween(800, 3000),
            'bedrooms'     => $this->faker->numberBetween(1, 5),
            'description'  => $this->faker->paragraph(),
            'is_active'    => true,
        ];
    }
}