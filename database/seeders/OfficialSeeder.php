<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;

class OfficialSeeder extends Seeder
{
    public function run(): void
    {
        Official::truncate();

        $officials = [

            // 🇵🇭 PRESIDENT & VICE PRESIDENT
            [
                'position' => 'president',
                'firstname' => 'Ferdinand',
                'middle_initial' => 'R',
                'lastname' => 'Marcos Jr.',
                'nickname' => 'BBM',
                'gender' => 'Male',
                'image_url' => 'https://source.unsplash.com/featured/200x200?president',
            ],
            [
                'position' => 'vice-president',
                'firstname' => 'Sara',
                'lastname' => 'Duterte',
                'nickname' => 'Inday',
                'gender' => 'Female',
                'image_url' => 'https://source.unsplash.com/featured/200x200?vice-president',
            ],

            // CABINET MEMBERS (sample list)
            ['position'=>'cabinet-member','firstname'=>'Enrique','lastname'=>'Manalo','nickname'=>'Ricky','gender'=>'Male','image_url'=>'https://source.unsplash.com/featured/200x200?minister'],
            ['position'=>'cabinet-member','firstname'=>'Benjamin','lastname'=>'Diokno','nickname'=>'Ben','gender'=>'Male','image_url'=>'https://source.unsplash.com/featured/200x200?finance'],
            ['position'=>'cabinet-member','firstname'=>'Jesus Crispin','lastname'=>'Remulla','gender'=>'Male','image_url'=>'https://source.unsplash.com/featured/200x200?justice'],

            // SENATORS (sample set)
            ['position'=>'senator','firstname'=>'Francis','middle_initial'=>'G','lastname'=>'Escudero','nickname'=>'Chiz','gender'=>'Male','party'=>'PDP–Laban','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Risa','lastname'=>'Hontiveros','gender'=>'Female','party'=>'Akbayan','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Robinhood','lastname'=>'Padilla','nickname'=>'Robin','gender'=>'Male','party'=>'PDP–Laban','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Imee','lastname'=>'Marcos','middle_initial'=>'R','gender'=>'Female','party'=>'PDP–Laban','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Pia','lastname'=>'Cayetano','gender'=>'Female','party'=>'Nacionalista','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Alan Peter','lastname'=>'Cayetano','middle_initial'=>'S','gender'=>'Male','party'=>'CIBAC','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Grace','lastname'=>'Poe','gender'=>'Female','party'=>'Independent','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Ronald','lastname'=>'Dela Rosa','nickname'=>'Bato','gender'=>'Male','party'=>'PDP–Laban','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Maria Lourdes Nancy','lastname'=>'Binay','middle_initial'=>'S','gender'=>'Female','party'=>'UNA','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            ['position'=>'senator','firstname'=>'Christopher Lawrence','lastname'=>'Go','middle_initial'=>'T','gender'=>'Male','party'=>'PDP–Laban','image_url'=>'https://source.unsplash.com/featured/200x200?senator'],
            // ... add remaining senators similarly

            // HOUSE REPRESENTATIVES (sample set)
            ['position'=>'hor','firstname'=>'Martin','lastname'=>'Romualdez','gender'=>'Male','party'=>'Lakas–CMD','image_url'=>'https://source.unsplash.com/featured/200x200?representative'],
            ['position'=>'hor','firstname'=>'France','lastname'=>'Castro','gender'=>'Female','party'=>'ACT Teachers','image_url'=>'https://source.unsplash.com/featured/200x200?teacher'],
            ['position'=>'hor','firstname'=>'Stella','lastname'=>'Quimbo','gender'=>'Female','party'=>'Liberal','image_url'=>'https://source.unsplash.com/featured/200x200?lawyer'],
            // ... add remaining HOR members similarly
        ];

        foreach ($officials as $data) {
            Official::create($data);
        }
    }
}
