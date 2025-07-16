<?php

namespace Database\Seeders;

use App\Models\Custom\{Event, EventInvite};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class EventSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        EventInvite::truncate();
        Event::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $titles = [
            'An Act Strengthening the Anti-Hospital Deposit Law to Penalize Refusal of Treatment During Emergencies...',
            'A Measure Promoting Digital Literacy Among Senior Citizens Across Rural Communities...',
            'An Act Mandating Free Annual Physical Exams for Public School Teachers...',
            'A Directive Establishing a National Food Waste Reduction Program...',
            'A Law Encouraging the Use of Renewable Energy in All Government Buildings...',
            'An Act Enhancing Cybersecurity Measures in Financial Institutions...',
            'A Measure Creating the National Center for Disease Control and Prevention...',
            'A Directive Implementing Mandatory Disaster Preparedness Drills in All Schools...',
            'An Act Expanding the Scholarship Coverage for Indigenous and Marginalized Students...',
            'A Law Requiring Transparency in Public Infrastructure Projects Through Real-Time Monitoring Portals...',
        ];

        $numEvents = 10;

        for ($i = 0; $i < $numEvents; $i++) {
            // Random date: past (-30), today (0), or future (+30)
            $randomDays = rand(-30, 30);

            // Random image filename from 1.jpg to 10.jpg
            $randomImage = 'images/samples/events/' . $i . '.jpg';
            // $randomImage = 'images/samples/events/' . rand(1, 10) . '.jpg';

            $randomTitle = $titles[array_rand($titles)];

            $event = Event::create([
                'title' => $randomTitle,
                'description' => $randomTitle,
                'event_cluster_id' => rand(1, 4),
                'date' => now()->addDays($randomDays)->format('Y-m-d'),
                'start_time' => now()->setTime(rand(7, 10), 0)->format('H:i'),
                'end_time' => now()->setTime(rand(13, 17), 0)->format('H:i'),
                'location' => 'Location ' . rand(1, 5),
                'attachments' => json_encode([]),
                'other_links' => json_encode([]),
                'event_img' => $randomImage,
                'invitation_file' => 'storage/events/' . $event->id . '/invitation/sample.jpg',
                'created_by' => 1,
            ]);

            // Randomly assign between 1 to 3 invite types
            $types = collect(['cluster', 'agency', 'member'])->shuffle()->take(rand(1, 3));

            foreach ($types as $type) {
                $numInvites = rand(1, 3);
                $uniqueIds = range(2, 4);
                shuffle($uniqueIds);

                for ($j = 0; $j < $numInvites; $j++) {
                    EventInvite::create([
                        'event_id' => $event->id,
                        'type' => $type,
                        'invited' => $uniqueIds[$j],
                        'invited_by' => $event->created_by,
                        'invitation_file' => 'storage/events/' . $event->id . '/invitation/sample.jpg',
                        'participant_limit' => $type === 'agency' ? 10 : 0,
                    ]);
                }
            }
        }
    }
}

// class EventSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $titles = [
//             'An Act Strengthening the Anti-Hospital Deposit Law to Penalize Refusal of Treatment During Emergencies...',
//             'A Measure Promoting Digital Literacy Among Senior Citizens Across Rural Communities...',
//             'An Act Mandating Free Annual Physical Exams for Public School Teachers...',
//             'A Directive Establishing a National Food Waste Reduction Program...',
//             'A Law Encouraging the Use of Renewable Energy in All Government Buildings...',
//             'An Act Enhancing Cybersecurity Measures in Financial Institutions...',
//             'A Measure Creating the National Center for Disease Control and Prevention...',
//             'A Directive Implementing Mandatory Disaster Preparedness Drills in All Schools...',
//             'An Act Expanding the Scholarship Coverage for Indigenous and Marginalized Students...',
//             'A Law Requiring Transparency in Public Infrastructure Projects Through Real-Time Monitoring Portals...',
//         ];


//         // Adjust how many events you want to seed
//         $numEvents = 10;

//         for ($i = 0; $i < $numEvents; $i++) {
//             $randomTitle = $titles[array_rand($titles)];
//             $event = Event::create([
//                 'title' => $randomTitle,
//                 'description' => $randomTitle,
//                 'event_cluster_id' => rand(1, 4),
//                 'date' => now()->addDays(rand(1, 60))->format('Y-m-d'),
//                 'start_time' => now()->addHours(1)->format('H:i'),
//                 'end_time' => now()->addHours(3)->format('H:i'),
//                 'location' => 'Location ' . rand(1, 5),
//                 'attachments' => json_encode([]),
//                 'other_links' => json_encode([]),
//                 'event_img' => null,
//                 'created_by' => 1, // Or Auth::id() if run in tinker
//             ]);

//             // Seed invites — adjust how many per event
//             $types = ['cluster', 'agency', 'member'];

//             foreach ($types as $type) {
//                 EventInvite::create([
//                     'event_id' => $event->id,
//                     'type' => $type,
//                     'invited' => rand(1, 4),
//                     'invited_by' => $event->created_by,
//                     'invitation_file' => null,
//                     'participant_limit' => $type === 'agency' ? 10 : 0,
//                 ]);
//             }
//         }
//     }
// }
