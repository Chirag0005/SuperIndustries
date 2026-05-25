<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = ['product_carved_train.png', 'product_premium_blocks.png', 'product_baby_rattle.png', 'hero.png', 'hamper.png'];
        $adjectives = ['Royal', 'Imperial', 'Heritage', 'Artisan', 'Classic', 'Grand', 'Luxury', 'Majestic', 'Premium', 'Timeless'];
        $woods = ['Oak', 'Mahogany', 'Walnut', 'Maple', 'Cedar', 'Birch', 'Ash', 'Cherry'];
        $items = ['Bear', 'Train Set', 'Building Blocks', 'Baby Rattle', 'Rocking Horse', 'Dollhouse', 'Puzzle', 'Music Box', 'Hamper', 'Gift Set'];
        
        $name = $this->faker->randomElement($adjectives) . ' ' . $this->faker->randomElement($woods) . ' ' . $this->faker->randomElement($items);

        return [
            'category_id' => $this->faker->numberBetween(1, 2),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . uniqid(),
            'description' => $this->faker->paragraph(3) . ' Hand-carved from sustainable wood and finished with organic, non-toxic oils.',
            'price' => $this->faker->randomFloat(2, 49, 499),
            'image' => $this->faker->randomElement($images),
            'is_featured' => $this->faker->boolean(20), // 20% chance to be featured
        ];
    }
}
