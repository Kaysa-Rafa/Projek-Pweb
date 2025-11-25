<?php
// database/factories/UserProfileFactory.php
namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraph(),
            'website' => $this->faker->url(),
            'twitter' => $this->faker->userName(),
            'github' => $this->faker->userName(),
            'location' => $this->faker->city(),
            'signature' => $this->faker->sentence(),
        ];
    }
}   