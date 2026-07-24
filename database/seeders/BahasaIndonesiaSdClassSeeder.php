<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CourseClass;
use App\Models\Material;
use App\Models\Subcategory;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class BahasaIndonesiaSdClassSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'bahasa-indonesia')->first();
        $subcategory = Subcategory::where('slug', 'bahasa-indonesia-sd')->first();
        $admin = User::where('email', 'admin@gmail.com')->first();
        $teacher = Teacher::whereHas('user', fn ($query) => $query->where('email', 'teacher@gmail.com'))->first();

        if (! $category || ! $subcategory || ! $admin) {
            return;
        }

        $class = CourseClass::updateOrCreate(
            ['slug' => 'bahasa-indonesia-sd-kurikulum-merdeka'],
            [
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'teacher_id' => $teacher?->id,
                'name' => 'Bahasa Indonesia SD',
                'description' => 'Kelas Bahasa Indonesia SD untuk membangun kemampuan membaca, menulis, berbicara, dan menyimak melalui materi yang dekat dengan keseharian siswa.',
                'status' => 'publish',
                'capacity' => 30,
                'is_featured' => true,
                'created_by' => $admin->id,
            ]
        );

        $materials = Material::where('subcategory_id', $subcategory->id)
            ->orderBy('created_at')
            ->get();

        $class->materials()->sync(
            $materials->mapWithKeys(fn ($material, $index) => [
                $material->id => ['order_number' => $index + 1],
            ])->all()
        );
    }
}
