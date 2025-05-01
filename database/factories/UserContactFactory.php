<?php

namespace Database\Factories;

use App\Models\UserContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserContact>
 */
class UserContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserContact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'address1' => $this->faker->streetAddress(),
            'address2' => $this->faker->secondaryAddress(),
            'address3' => $this->faker->city(),
            'postcode' => $this->faker->postcode(),
            'country_id' => $this->faker->randomElement(['1', '2', '3']), // Adjust based on your countries table
        ];
    }
}
