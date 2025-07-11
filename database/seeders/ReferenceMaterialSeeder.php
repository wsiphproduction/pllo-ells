<?php

namespace Database\Seeders;

use App\Models\Custom\ReferenceMaterial;
use Illuminate\Database\Seeder;

class ReferenceMaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Optionally truncate the table first
        ReferenceMaterial::truncate();

        $levels = ['Agency Priority', 'President Legislative Priorities'];
        $subjects = [
            'Sustainable Energy Reform',
            'Digital Governance Transformation',
            'Public Health Strategy',
            'Educational Innovation Plan',
            'National Food Security Blueprint',
            'Transportation Infrastructure Upgrade',
            'Cybersecurity Enhancement Act',
            'Inclusive Housing Program',
            'Cultural Heritage Preservation',
            'Water Resource Management Law'
        ];

        $num = 10;

        for ($i = 0; $i < $num; $i++) {
            ReferenceMaterial::create([
                'subject' => $subjects[array_rand($subjects)],
                'significance_level' => $levels[array_rand($levels)],
                'cluster_id' => rand(1, 4),
                'agency_id' => rand(2, 4),
                'attachments' => '["storage\/reference-materials\/1\/attachments\/1st Sample Forms 3-12-2025 (4).pdf","storage\/reference-materials\/1\/attachments\/PA PRINT KO GAW PALIHUG LAMAAATS (5).pdf","storage\/reference-materials\/1\/attachments\/FSI Book Inventory System Memo (2).pdf"]', 
                'remarks' => 'Auto-generated test entry.',
                'created_by' => 1 
            ]);
        }
    }
}
