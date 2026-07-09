<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\UmumUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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

        // Define all permissions grouped by module
        $permissions = [
            // Category
            'category.index',
            'category.create',
            'category.edit',
            'category.delete',

            // Subcategory
            'subcategori.index',
            'subcategori.create',
            'subcategori.edit',
            'subcategori.delete',

            // Materi
            'materi.index',
            'materi.create',
            'materi.edit',
            'materi.delete',

            // Mindmap
            'mindmap.index',

            // Roles
            'roles.index',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Permissions
            'permissions.index',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Users
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $umumRole    = Role::firstOrCreate(['name' => 'umum']);

        // Admin: semua permissions
        $adminRole->syncPermissions($permissions);

        // Teacher: hanya akses category, subcategori, materi, mindmap (tidak bisa manage roles/permissions/users)
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
            ]
        );
        $teacherUser->syncRoles([$teacherRole]);
        Teacher::firstOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'slug' => 'guru-mindmap',
                'specialization' => 'Matematika & Fisika',
                'category' => 'akademik',
                'description' => 'Guru default untuk testing aplikasi MindMap',
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
        $irfan = User::where('email', 'irfanadiprasetyo27@gmail.com')->first();
        if ($irfan) {
            $irfan->syncRoles([$adminRole]);
        }
    }
}
