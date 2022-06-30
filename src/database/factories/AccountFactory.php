<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_number' => $this->faker->unique()->numerify('##########'),
            'balance' => randomNumber($this->faker->numberBetween(5, 15), true),
            'user_id' => User::all()->random()->id,
        ];
    }
}
