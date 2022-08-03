<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $title = $this->faker->sentence(),
            'slug' => str()->slug($title),
            'file' => $this->faker->imageUrl($width = 1920, $height = 1280),
            'dimensions' => $width . 'x' . $height,
            'views_count' => $this->faker->randomNumber(5),
            'downloads_count' => $this->faker->randomNumber(5),
            'is_published' => true,
            'user_id' => User::factory(),

        ];
    }
}
