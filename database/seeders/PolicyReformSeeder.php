<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\PolicyReform;

class PolicyReformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PolicyReform::insert([
                    [
                        'member_id' => '24',
                        'title' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore',
                        'category' => 'Medical',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                        'photo' => 'storage/news_image/news_thumbnail/pr1.png',
                        'like' => '27',
                        'dislike' => '3',
                        'target_votes' => '120',
                        'until' => '2028-09-10',
                    ],
                    [
                        'member_id' => '24',
                        'title' => 'Aute irure dolor in reprehenderit in voluptate velit esse cillum dolore',
                        'category' => 'Security',
                        'description' => 'orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'photo' => 'storage/news_image/news_thumbnail/pr1.png',
                        'like' => '7',
                        'dislike' => '6',
                        'target_votes' => '100',
                        'until' => '2030-11-04',
                    ],
                    [
                        'member_id' => '24',
                        'title' => 'irure dolor in reprehenderit in voluptate velit esse cillum dolore',
                        'category' => 'Transportation',
                        'description' => 'orem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'photo' => 'storage/news_image/news_thumbnail/pr1.png',
                        'like' => '91',
                        'dislike' => '25',
                        'target_votes' => '150',
                        'until' => '2026-01-05',
                    ]
                ]);
    }
}
