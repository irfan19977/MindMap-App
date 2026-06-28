<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\Material;
use Carbon\Carbon;

class UserProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (or create one if doesn't exist)
        $user = User::first();
        
        if (!$user) {
            $this->command->warn('No user found. Please create a user first.');
            return;
        }

        // Get all materials
        $materials = Material::all();

        if ($materials->isEmpty()) {
            $this->command->warn('No materials found. Please run SampleDataSeeder first.');
            return;
        }

        // Create sample progress data for the user
        $progressData = [
            [
                'material_id' => $materials[0]->id,
                'progress_percentage' => 100,
                'completed_at' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'material_id' => $materials[1]->id,
                'progress_percentage' => 75,
                'completed_at' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'material_id' => $materials[2]->id,
                'progress_percentage' => 100,
                'completed_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'material_id' => $materials[3]->id,
                'progress_percentage' => 30,
                'completed_at' => null,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'material_id' => $materials[4]->id,
                'progress_percentage' => 0,
                'completed_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($progressData as $data) {
            UserProgress::create([
                'user_id' => $user->id,
                'material_id' => $data['material_id'],
                'progress_percentage' => $data['progress_percentage'],
                'completed_at' => $data['completed_at'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        $this->command->info('User progress data created successfully for user: ' . $user->name);
    }
}
