<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Category',
                'slug' => 'category',
                'icon' => 'feather-folder',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Subcategory',
                'slug' => 'subcategory',
                'icon' => 'feather-layers',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Materi',
                'slug' => 'materi',
                'icon' => 'feather-book-open',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Classes',
                'slug' => 'classes',
                'icon' => 'feather-users',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Mindmap',
                'slug' => 'mindmap',
                'icon' => 'feather-git-branch',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Reports',
                'slug' => 'reports',
                'icon' => 'feather-file-text',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Analytics',
                'slug' => 'analytics',
                'icon' => 'feather-bar-chart-2',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Users',
                'slug' => 'users',
                'icon' => 'feather-user',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Roles',
                'slug' => 'roles',
                'icon' => 'feather-shield',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Permissions',
                'slug' => 'permissions',
                'icon' => 'feather-lock',
                'order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Collaboration',
                'slug' => 'collaboration',
                'icon' => 'feather-users',
                'order' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(
                ['slug' => $menu['slug']],
                $menu
            );
        }
    }
}
