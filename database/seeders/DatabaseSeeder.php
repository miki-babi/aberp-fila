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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 5 Categories
        $categories = \App\Models\Category::factory(5)->create();

        foreach ($categories as $category) {
            // Create 3 SubCategories for each Category
            $subCategories = \App\Models\SubCategory::factory(3)->create([
                'category_id' => $category->id,
            ]);

            foreach ($subCategories as $subCategory) {
                // Create 3 Specs for each SubCategory (and link to Category)
                $specs = \App\Models\Spec::factory(3)->create([
                    'category_id' => $category->id,
                    'sub_category_id' => $subCategory->id,
                ]);

                foreach ($specs as $spec) {
                    // Create 5 Products for each Spec (and link to Category and SubCategory)
                    \App\Models\Product::factory(5)->create([
                        'category_id' => $category->id,
                        'sub_category_id' => $subCategory->id,
                        'spec_id' => $spec->id,
                    ]);
                }
            }
        }
    }
}
