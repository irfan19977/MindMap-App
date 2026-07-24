<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'bahasa-indonesia' => 'Bahasa Indonesia',
        ];

        $levels = ['sd'];
        $curriculum = 'Kurikulum Merdeka';

        foreach ($subjects as $slug => $name) {
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                foreach ($levels as $level) {
                    Subcategory::updateOrCreate(
                        ['slug' => $slug . '-' . $level],
                        [
                            'category_id' => $category->id,
                            'name' => $name . ' ' . strtoupper($level),
                            'grade_level' => $level,
                            'curriculum' => $curriculum,
                            'status' => 'publish',
                            'is_featured' => false,
                            'created_by' => $category->created_by,
                        ]
                    );
                }
            }
        }
    }
}
