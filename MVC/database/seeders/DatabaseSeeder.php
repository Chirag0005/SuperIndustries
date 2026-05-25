<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@superindustries.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@superindustries.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $toysCategory = \App\Models\Category::create([
            'name' => 'Premium Soft Toys',
            'slug' => 'premium-soft-toys',
            'description' => 'Exquisite, hand-crafted wooden soft toys for the finest play experiences.',
        ]);

        $hampersCategory = \App\Models\Category::create([
            'name' => 'Luxury Hampers',
            'slug' => 'luxury-hampers',
            'description' => 'Elegant and natural wooden hampers, perfect for gifting.',
        ]);

        \App\Models\Product::create([
            'category_id' => $toysCategory->id,
            'name' => 'The Grand Oak Bear',
            'slug' => 'the-grand-oak-bear',
            'description' => 'A masterpiece of craftsmanship. Hand-carved from sustainable oak and finished with organic oils.',
            'price' => 149.99,
            'image' => 'hero.png',
            'is_featured' => true,
        ]);

        \App\Models\Product::create([
            'category_id' => $hampersCategory->id,
            'name' => 'The Imperial Baby Hamper',
            'slug' => 'imperial-baby-hamper',
            'description' => 'A luxurious selection of wooden toys and organic cotton essentials, beautifully presented in a handcrafted wooden hamper.',
            'price' => 299.99,
            'image' => 'hamper.png',
            'is_featured' => true,
        ]);

        \App\Models\Product::factory(50)->create();
    }
}
