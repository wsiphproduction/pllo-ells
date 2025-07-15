<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PolicyReformCategory;

class PolicyReformCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PolicyReformCategory::insert([
                    [
                        'user_id' => '1',
                        'name' => 'medical'
                    ],
                    [
                        'user_id' => '1',
                        'name' => 'transportation'
                    ],
                    [
                        'user_id' => '1',
                        'name' => 'security'
                    ]
                ]);
    }
}
