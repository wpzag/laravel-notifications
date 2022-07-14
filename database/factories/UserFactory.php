<?php

    namespace Wpzag\LaravelNotifications\Database\Factories;

    use Illuminate\Database\Eloquent\Factories\Factory;

    use Illuminate\Support\Str;

    use Wpzag\LaravelNotifications\Tests\TestModels\User;

    class UserFactory extends Factory
    {
        protected $model = User::class;

        public function definition(): array
        {
            return [
                'name' => fake()->name(),
                'email' => fake()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ];
        }
    }
