<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Mindmap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MindmapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['matematika', 'bahasa-indonesia', 'ipa', 'ips', 'bahasa-inggris'];
        
        foreach ($subjects as $subject) {
            $materials = Material::whereHas('subcategory', function($query) use ($subject) {
                $query->where('slug', 'like', $subject . '%');
            })->limit(10)->get();
            
            if ($materials->isNotEmpty()) {
                $this->createMindmapForSubject($materials, $subject);
            }
        }
    }
    
    private function createMindmapForSubject($materials, $subjectSlug)
    {
        $nodes = [];
        $edges = [];
        $nodeIdCounter = 1;
        
        // Root node
        $rootId = '1';
        $subjectName = $this->getSubjectName($subjectSlug);
        $nodes[] = [
            'id' => $rootId,
            'text' => $subjectName,
            'x' => 400,
            'y' => 300,
            'color' => '#4F46E5',
            'fontSize' => 24,
            'isRoot' => true,
        ];
        
        $currentY = 100;
        
        foreach ($materials as $index => $material) {
            $materialNodeId = strval($nodeIdCounter++);
            $nodes[] = [
                'id' => $materialNodeId,
                'text' => $material->title,
                'x' => $index === 0 ? 200 : ($index === 1 ? 400 : 600),
                'y' => $currentY,
                'color' => '#6B7280',
                'fontSize' => 12,
                'parentId' => $rootId,
            ];
            
            $edges[] = ['from' => $rootId, 'to' => $materialNodeId];
            
            $currentY += 50;
        }
        
        Mindmap::create([
            'material_id' => $materials->first()->id,
            'title' => $subjectName . ' Mindmap',
            'structure' => [
                'nodes' => $nodes,
                'edges' => $edges,
            ],
            'status' => 'publish',
        ]);
    }
    
    private function getSubjectName($slug)
    {
        return match($slug) {
            'matematika' => 'Matematika',
            'bahasa-indonesia' => 'Bahasa Indonesia',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'bahasa-inggris' => 'Bahasa Inggris',
            default => 'Unknown',
        };
    }
}
