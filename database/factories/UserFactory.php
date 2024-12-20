<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            // 'name' => 'Factory User', // Use a static name for predictability in tests
            'email' => $this->faker->unique()->safeEmail(),
            'role' => $this->faker->randomElement(['User', 'Admin']),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            // 'password' => Hash::make('password'), // Match test input
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the factory to create related UserContact data.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            UserContact::factory()->create([
                'user_id' => $user->id,
                'phone' => $this->faker->phoneNumber(),
                'mobile' => $this->faker->phoneNumber(),
                'address1' => $this->faker->streetAddress(),
                'address2' => $this->faker->secondaryAddress(),
                'address3' => $this->faker->city(),
                'postcode' => $this->faker->postcode(),
                'country_id' => $this->faker->randomElement([1, 2, 3]),
            ]);
        });
    }
}