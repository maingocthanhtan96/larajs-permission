<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraJS\Permission\Models\Role;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => strtoupper($this->faker->userName),
        ];
    }
}
