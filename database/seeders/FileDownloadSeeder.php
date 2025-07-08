<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class FileDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear existing data first
        Schema::disableForeignKeyConstraints();
        DB::table('file_download')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker   = Faker::create();
        $titles = [
            'An Act Strengthening the Anti-Hospital Deposit Law to Penalize Refusal of Treatment During Emergencies. This measure aims to ensure that all patients, regardless of financial capability, receive timely medical attention during emergencies. It imposes stricter penalties on hospitals and clinics that deny urgent care based on inability to pay. The law reaffirms healthcare as a fundamental human right.',
            
            'A Measure Promoting Digital Literacy Among Senior Citizens Across Rural Communities. The initiative seeks to bridge the digital divide by providing free training programs on basic computer skills and internet usage. Special focus will be given to mobile banking, online communication, and accessing government services. The goal is to empower seniors to fully participate in an increasingly digital society.',
            
            'An Act Mandating Free Annual Physical Exams for Public School Teachers. This law guarantees government-funded medical check-ups to monitor and maintain the health of educators. It recognizes the physical and mental demands placed on teachers and aims to provide early detection of common illnesses. Healthier teachers result in better educational outcomes for students.',
            
            'A Directive Establishing a National Food Waste Reduction Program. This directive encourages households, restaurants, and food businesses to adopt sustainable practices to minimize waste. It includes incentives for donations of surplus food and penalties for excessive discarding of edible goods. The program aligns with global environmental goals and addresses local food insecurity.',
            
            'A Law Encouraging the Use of Renewable Energy in All Government Buildings. The legislation mandates the installation of solar panels, wind turbines, or other clean energy systems in public offices and facilities. It also provides funding for retrofitting older structures to improve energy efficiency. By leading by example, the government aims to reduce carbon emissions nationwide.',
            
            'An Act Enhancing Cybersecurity Measures in Financial Institutions. This act compels banks and fintech firms to strengthen their data protection frameworks through modern encryption and regular security audits. It also establishes a central cybersecurity command for rapid incident response. The law is designed to safeguard public trust and prevent financial data breaches.',
            
            'A Measure Creating the National Center for Disease Control and Prevention. The center will serve as the primary agency for disease surveillance, outbreak response, and health crisis coordination. It will be equipped with modern labs and trained personnel to monitor public health threats. This measure ensures the country is better prepared for pandemics and health emergencies.',
            
            'A Directive Implementing Mandatory Disaster Preparedness Drills in All Schools. The policy requires quarterly earthquake, fire, and evacuation drills for both students and staff. It aims to instill a culture of readiness and reduce panic during actual emergencies. The directive also mandates the updating of school safety protocols and evacuation maps.',
            
            'An Act Expanding the Scholarship Coverage for Indigenous and Marginalized Students. This legislation provides full tuition and stipend support for qualified learners in both secondary and tertiary levels. It recognizes the systemic barriers faced by underrepresented communities in accessing education. The act aims to promote equality and inclusive development through learning.',
            
            'A Law Requiring Transparency in Public Infrastructure Projects Through Real-Time Monitoring Portals. This measure mandates the creation of online platforms where citizens can view updates on government-funded construction. It includes geotagged photos, project timelines, and budget breakdowns. Transparency is expected to reduce corruption and improve project efficiency.',
        ];


        $sourceLevels = ['Sona Measure', 'Directive', 'Constitution'];

        $records = [];

        for ($i = 0; $i < 20; $i++) {               // ← adjust count as needed
            $records[] = [
                // 'title'                 => $faker->unique()->sentence(30),
                'title'                => $titles[$i % count($titles)],
                'file_url'              => '1751334143_Fast Moving Items.csv',
                'status'                => 1,
                'unique_hash'           => Str::random(32),
                'ra_jr'                 => (string) (11500 + $i),
                'approved_on'           => $faker->unique()
                                                  ->dateTimeBetween('-2 years', 'now')
                                                  ->format('Y-m-d'),
                'congress'              => $faker->numberBetween(8, 19) . 'th',
                'source_priority_level' => $sourceLevels[array_rand($sourceLevels)],
                'created_at'            => now(),
                'updated_at'            => now(),
            ];
        }

        \App\Models\FileDownload::insert($records);

        // \App\Models\FileDownload::insert([
        //     [
        //         'title' => 'The supreme law of the land that establishes the structure of government, fundamental rights, and the guiding principles of the Republic of the Philippines. It replaced the 1973 Constitution and restored democracy after the Marcos regime.',
        //         'file_url'=> '1751334143_Fast Moving Items.csv',
        //         'status' => 1,
        //         'unique_hash' => 'aS4oE373Cp1u0P1r3AK3o9rIvtJ2NyYR',
        //         'ra_jr' => '11543',
        //         'approved_on' => '2025-05-01',
        //         'congress' => '8th',
        //         'source_priority_level' => 'Constitution',
        //         'created_at' => date("Y-m-d H:i:s"),
        //         'updated_at' => date("Y-m-d H:i:s")
        //     ],
        // ]);
    }
}
