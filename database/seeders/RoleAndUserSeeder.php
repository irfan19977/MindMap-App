<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\UmumUser;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions grouped by module with menu mapping
        $permissions = [
            // Category
            ['name' => 'category.index', 'menu_slug' => 'category'],
            ['name' => 'category.create', 'menu_slug' => 'category'],
            ['name' => 'category.edit', 'menu_slug' => 'category'],
            ['name' => 'category.delete', 'menu_slug' => 'category'],

            // Subcategory
            ['name' => 'subcategori.index', 'menu_slug' => 'subcategory'],
            ['name' => 'subcategori.create', 'menu_slug' => 'subcategory'],
            ['name' => 'subcategori.edit', 'menu_slug' => 'subcategory'],
            ['name' => 'subcategori.delete', 'menu_slug' => 'subcategory'],

            // Materi
            ['name' => 'materi.index', 'menu_slug' => 'materi'],
            ['name' => 'materi.create', 'menu_slug' => 'materi'],
            ['name' => 'materi.edit', 'menu_slug' => 'materi'],
            ['name' => 'materi.delete', 'menu_slug' => 'materi'],

            // Mindmap
            ['name' => 'mindmap.index', 'menu_slug' => 'mindmap'],
            ['name' => 'mindmap.create', 'menu_slug' => 'mindmap'],
            ['name' => 'mindmap.edit', 'menu_slug' => 'mindmap'],
            ['name' => 'mindmap.delete', 'menu_slug' => 'mindmap'],

            // Classes
            ['name' => 'classes.index', 'menu_slug' => 'classes'],
            ['name' => 'classes.create', 'menu_slug' => 'classes'],
            ['name' => 'classes.edit', 'menu_slug' => 'classes'],
            ['name' => 'classes.delete', 'menu_slug' => 'classes'],

            // Roles
            ['name' => 'roles.index', 'menu_slug' => 'roles'],
            ['name' => 'roles.create', 'menu_slug' => 'roles'],
            ['name' => 'roles.edit', 'menu_slug' => 'roles'],
            ['name' => 'roles.delete', 'menu_slug' => 'roles'],

            // Permissions
            ['name' => 'permissions.index', 'menu_slug' => 'permissions'],
            ['name' => 'permissions.create', 'menu_slug' => 'permissions'],
            ['name' => 'permissions.edit', 'menu_slug' => 'permissions'],
            ['name' => 'permissions.delete', 'menu_slug' => 'permissions'],

            // Users
            ['name' => 'users.index', 'menu_slug' => 'users'],
            ['name' => 'users.create', 'menu_slug' => 'users'],
            ['name' => 'users.edit', 'menu_slug' => 'users'],
            ['name' => 'users.delete', 'menu_slug' => 'users'],

            // Collaborations
            ['name' => 'collaboration.index', 'menu_slug' => 'collaboration'],
            ['name' => 'collaboration.create', 'menu_slug' => 'collaboration'],
            ['name' => 'collaboration.edit', 'menu_slug' => 'collaboration'],
            ['name' => 'collaboration.delete', 'menu_slug' => 'collaboration'],

            // Reports
            ['name' => 'reports.index', 'menu_slug' => 'reports'],
            ['name' => 'reports.users', 'menu_slug' => 'reports'],
            ['name' => 'reports.mindmap', 'menu_slug' => 'reports'],
            ['name' => 'reports.learning', 'menu_slug' => 'reports'],

            // Analytics
            ['name' => 'analytics.index', 'menu_slug' => 'analytics'],
        ];

        // Create all permissions with menu linkage
        foreach ($permissions as $permissionData) {
            $menu = Menu::where('slug', $permissionData['menu_slug'])->first();
            
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['menu_id' => $menu ? $menu->id : null]
            );
        }

        // Extract permission names for role assignment
        $permissionNames = array_column($permissions, 'name');

        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $umumRole    = Role::firstOrCreate(['name' => 'umum']);

        // Admin: semua permissions
        $adminRole->syncPermissions($permissionNames);

        // Teacher: akses category, subcategori, materi, mindmap, classes, reports, analytics (tidak bisa manage roles/permissions/users)
        $teacherRole->syncPermissions([
            'category.index',
            'category.create',
            'category.edit',
            'category.delete',
            'subcategori.index',
            'subcategori.create',
            'subcategori.edit',
            'subcategori.delete',
            'materi.index',
            'materi.create',
            'materi.edit',
            'materi.delete',
            'mindmap.index',
            'mindmap.create',
            'mindmap.edit',
            'mindmap.delete',
            'classes.index',
            'classes.create',
            'classes.edit',
            'classes.delete',
            'reports.index',
            'reports.users',
            'reports.mindmap',
            'reports.learning',
            'analytics.index',
        ]);

        // Student: tidak ada akses backend
        $studentRole->syncPermissions([]);

        // Umum: tidak ada akses backend
        $umumRole->syncPermissions([]);

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'      => 'Admin MindMap',
                'password'  => bcrypt('password'),
                'user_type' => 'admin',
            ]
        );
        $admin->syncRoles([$adminRole]);

        // Create Teacher user + teacher profile
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@gmail.com'],
            [
                'name'      => 'Guru MindMap',
                'password'  => bcrypt('password'),
                'user_type' => 'teacher',
                'is_active' => true,
                'teacher_verification_status' => 'approved',
            ]
        );
        $teacherUser->update([
            'user_type' => 'teacher',
            'is_active' => true,
            'teacher_verification_status' => 'approved',
        ]);
        $teacherUser->syncRoles([$teacherRole]);
        Teacher::updateOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'slug' => 'guru-mindmap',
                'specialization' => 'Bahasa Indonesia SD',
                'category' => 'akademik',
                'description' => 'Guru default untuk materi Bahasa Indonesia SD di aplikasi MindMap',
                'education' => 'S1 Pendidikan',
                'experience' => '5 tahun mengajar',
            ]
        );

        // Create Student user + student profile
        $studentUser = User::firstOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name'      => 'Siswa MindMap',
                'password'  => bcrypt('password'),
                'user_type' => 'student',
            ]
        );
        $studentUser->syncRoles([$studentRole]);
        Student::firstOrCreate(
            ['user_id' => $studentUser->id],
            [
                'school' => 'SMA Negeri 1',
            ]
        );

        // Create Umum user + umum profile
        $umumUser = User::firstOrCreate(
            ['email' => 'umum@gmail.com'],
            [
                'name'      => 'User Umum',
                'password'  => bcrypt('password'),
                'user_type' => 'student',
            ]
        );
        $umumUser->syncRoles([$umumRole]);
        UmumUser::firstOrCreate(
            ['user_id' => $umumUser->id],
            [
                'occupation' => 'Karyawan',
            ]
        );

        // Assign admin role to existing Irfan user if present
        // $irfan = User::where('email', 'irfanadiprasetyo27@gmail.com')->first();
        // if ($irfan) {
        //     $irfan->syncRoles([$adminRole]);
        // }
    }
}
